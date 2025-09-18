<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Slider;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->whereIn('type', [2,3])->limit(10)->with(['firstImage','category','wishlists'])
                ->withAvg('reviews', 'rating')->withCount('reviews');
            }
        ])->where('status', 1)->get();

        $products = Product::with([
            'category', 
            'firstImage',
            'wishlists' => function($q) {
                $q->where('user_id', Auth::id());
            }
        ])->whereIn('type', [2,3])->where('status', 1)
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')->limit(10)->get();

        $sliders = Slider::where('status', 1)->get();

        $popularKeywords = DB::table('search_logs')
            ->select('keyword', DB::raw('COUNT(DISTINCT ip_address) as total'))
            ->groupBy('keyword')
            ->orderByDesc('total')
            ->limit(20)
            ->get();

        $topSelling = Product::with([
                'category', 
                'firstImage',
                'wishlists' => function($q) {
                    $q->where('user_id', Auth::id());
                }
            ])
            ->select('products.id', 'products.category_id',  'products.slug', 'products.name', 'products.slug', 'products.price', 'products.type', DB::raw('SUM(transaction_items.qty) as total_sold'),
            
                DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id) as reviews_avg_rating'),
                DB::raw('(SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id) as reviews_count')
            )
            ->join('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.status', 2)
            ->where('products.status', 1)
            ->whereIn('products.type', [2,3])
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $rentProducts = Product::with([
            'category', 
            'firstImage',
            'wishlists' => function($q) {
                $q->where('user_id', Auth::id());
            }
        ])->where('status', 1)->where('type', 1)->limit(10)->get();

        return view('frontend.index', compact('categories', 'products', 'sliders','popularKeywords', 'topSelling', 'rentProducts'));
    }

    public function showProduct(Request $request, $category, $product = null)
    {
        if ($product) {
            $product = Product::with('category', 'images')->where('status', 1)->where('slug', $product)->first();

            if (!$product) return redirect()->route('frontend.index');
            
            $rent_product = [];
            if ($request->filled('param')) {
                try {
                    $decryptParam = decrypt($request->param);
                    $param = json_decode($decryptParam, true);

                    $startDate = Carbon::parse($param['start_date']);
                    $endDate   = Carbon::parse($param['end_date']);

                    $exists = TransactionItem::where('product_id', $product->id)
                        ->whereHas('transaction', function ($q) {
                            $q->whereIn('status', [1, 2]); // hanya transaksi aktif/selesai
                        })
                        ->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($q2) use ($startDate, $endDate) {
                                $q2->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                        })
                        ->exists();

                    if ($exists) {
                        return redirect('/');
                    }
                        
                    $weekdayHours = 0;
                    $weekendHours = 0;

                    // Loop tiap jam dalam periode
                    $period = CarbonPeriod::create($startDate, '1 hour', $endDate)->excludeEndDate();

                    foreach ($period as $dateTime) {
                        $hour = (int)$dateTime->format('H');

                        // Hitung hanya jam kerja 08:00–17:00
                        if ($hour >= 8 && $hour < 17) {
                            if ($dateTime->isWeekend()) {
                                $weekendHours++;
                            } else {
                                $weekdayHours++;
                            }
                        }
                    }
                    $rent_product = [
                        'weekday_hours' => $weekdayHours,
                        'weekend_hours' => $weekendHours,
                        'total_hours'   => $weekdayHours + $weekendHours,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'total_price' => ($weekdayHours * $product->base_price_per_hour)+ ($weekendHours*$product->holiday_price_per_hour)
                    ];
                } catch (\Exception $e) {
                    return redirect()->route('frontend.index');
                }

            }

            $pendingStock = DB::table('transactions as a')
                ->leftJoin('transaction_items as b', 'a.id', '=', 'b.transaction_id')
                ->where('b.product_id', $product->id)
                ->whereIn('a.status', [1]) 
                ->sum('b.qty');

            $relatedProducts = Product::with([
                    'category', 
                    'firstImage',
                    'wishlists' => function($q) {
                        $q->where('user_id', Auth::id());
                    }
                ])->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->inRandomOrder() // ambil acak
                ->take(7)
                ->get();

            return view('frontend.pages.product-detail', compact('product', 'pendingStock', 'relatedProducts', 'rent_product'));
        } else {
            $dataCategory = null;
            $search = null;
            $query = Product::with([
                    'firstImage', 
                    'category',
                    'wishlists' => function($q) {
                        $q->where('user_id', Auth::id());
                    }
                ])
                ->select('products.*')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->whereIn('products.type', [2,3])
                ->where('products.status', 1);

            if ($category == 'all') {
                $search = $request->query('q');
                if ($search) {
                    $query->where('products.name', 'like', '%' . $search . '%');

                    #insert search log
                    SearchLog::create([
                        'keyword' => strtolower($search),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                    ]);
                }
            } else {
                $dataCategory = Category::where('status', 1)->where('slug', $category)->first();

                if (!$dataCategory) return redirect()->route('frontend.index');

                $query->where('categories.slug', $category);
            }
            $products = $query->paginate(10)->withQueryString();

            return view('frontend.pages.product-category', compact('products', 'dataCategory', 'search'));
        }
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index');
        }

        #carts
        $checkoutCarts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        if (count($checkoutCarts) < 1) {
            return redirect()->route('frontend.index');
        }

        $totalPrice = $checkoutCarts->sum(fn($c) => $c->price * $c->qty);

        return view('frontend.pages.checkout', compact('checkoutCarts', 'totalPrice'));
    }

    
    public function checkoutProcess(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error' => 'Silahkan login terlebih dahulu untuk menambahkan produk ke keranjang.']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'phone' => 'required|max:20',
            'address' => 'required',
            // 'city' => 'required|max:50',
            // 'postal_code' => 'required|max:5',
        ]);
        $validator->validate();

        try {
            DB::beginTransaction();

            $total = 0;

            foreach ($request->carts as $k => $v) {
                $cart = Cart::with('product')->where('id', decrypt($v))->first();

                $stock = $cart->product->qty;

                if($cart->product->type != 1) {
                    $pendingStock = DB::table('transactions as a')
                        ->leftJoin('transaction_items as b', 'a.id', '=', 'b.transaction_id')
                        ->where('b.product_id', $cart->product_id)
                        ->whereIn('a.status', [1]) 
                        ->sum('b.qty');

                    $availableStock = $stock - $pendingStock;

                    if ($cart->qty > $availableStock) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
                    }
                }
            }

            $code = 'TRX' . date('Ymd') . strtoupper(Str::random(6));
            $transaction = Transaction::create([
                'user_id'        => Auth::id(),
                'name'           => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                // 'city'           => $request->city,
                // 'postal_code'    => $request->postal_code,
                'payment_method' => $request->payment_method,
                'total'          => 0,
                'status'         => 1,
                'payment_status' => 1,
                'code'           => $code,
            ]);

            foreach ($request->carts as $v) {
                $cart = Cart::with('product')->where('id', decrypt($v))->first();

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $cart->product_id,
                    'price'          => $cart->price,
                    'qty'            => $cart->qty,
                    'subtotal'       => $cart->subtotal,
                    'start_date'     => $cart->start_date,
                    'end_date'       => $cart->end_date,
                ]);

                $total += $cart->subtotal;

                $cart->delete();
            }

            $transaction->update(['total' => $total]);

            DB::commit();

            return redirect()->route('frontend.invoice', ['code' => $code]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    
    public function invoice($code)
    {
        if (!Auth::check()) return redirect()->route('frontend.index');
    
        $invoice = Transaction::select('transactions.*')
            ->with('transactionItems')
            ->where('user_id', Auth::user()->id)
            ->where('code', $code)->first();
        if (!$invoice) return redirect()->route('frontend.index');

        return view('frontend.pages.invoice', compact('invoice'));
    }

    public function aboutUs()
    {
        return view('frontend.pages.about');
    }

    public function contactUs()
    {
        return view('frontend.pages.contact');
    }

    public function faq()
    {
        $faqs = Faq::where('status', 1)->orderBy('order', 'asc')->get();
        
        return view('frontend.pages.faq', compact('faqs'));
    }

    public function searchRentals(Request $request) {
        $startDate = $request->start_datetime;//'2025-09-15 09:00:00';
        $endDate   = $request->end_datetime;//'2025-09-15 10:00:00';

        try {
            $products = Product::whereDoesntHave('transactionDetails', function ($q) use ($startDate, $endDate) {
                $q->where('start_date', '<', $endDate)
                ->where('end_date', '>', $startDate)
                ->whereHas('transaction', function($t) {
                    $t->whereIn('status', [1, 2]);
                });
            })->with([
                'category', 
                'firstImage',
                'wishlists' => function($q) {
                    $q->where('user_id', Auth::id());
                }
            ])->where('products.type', 1)->get();

            return response()->json([
                'status' => true,
                'data' => $products,
                'param' => encrypt(json_encode(['start_date' => $startDate, 'end_date' => $endDate]))
            ]);
        } catch (\Exception $e) {
        
            return response()->json([
                'status' => false,
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    public function productRentalPage()
    {
        return view('frontend.pages.rental');
    }

    public function readBook($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product) abort(404);

        $token = Str::random(40);
        session(['pdf_token' => $token]);

        return view('frontend.pages.read-book', compact('product', 'token'));
    }
}

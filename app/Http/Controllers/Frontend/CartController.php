<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error' => 'Silahkan login terlebih dahulu untuk menambahkan produk ke keranjang.']);
        }
        if (Auth::user()->role != 'customer') {
            return redirect()->back()->with(['error' => 'Hanya customer yang bisa menambahkan ke keranjang.']);
        }
        $id = decrypt($id);
        if($request->type == 2) {
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|numeric|min:1',
            ]);
            $validator->validate();
        }

        try {
            $product = Product::with('category')->where('status', 1)->where('id', $id)->first();

            $cart = Cart::where('product_id', $product->id)->where('user_id', Auth::id())->first();

            if($product->type == 1) { #rent
                try {
                    $param = decrypt($request->param);
                    if ($cart) {
                        $cart->qty = 1;
                        $cart->start_date = $param['start_date'];
                        $cart->end_date = $param['end_date'];
                        $cart->subtotal = $param['total_price'];
                        $cart->save();
                    } else {
                        Cart::create([
                            'user_id'    => Auth::id(),
                            'product_id' => $product->id,
                            'price'      => $param['total_price'],
                            'start_date' => $param['start_date'],
                            'end_date'   => $param['end_date'],
                            'qty'        => 1,
                            'subtotal'   => $param['total_price'],
                        ]);
                    }
                } catch (\Exception $e) {
                    return redirect()->route('frontend.index');
                }
            } else { #product
                $variant_id = null;
                if ($product->type == 3) {
                    $request->merge(['quantity' => 1]);
                }
                $price = $product->price; 
                if ($product->type == 2) {
                    if (!$request->filled('variant_id')) {
                        return redirect()->back()->with(['error' => 'Silahkan pilih varian produk terlebih dahulu.']);
                    }
                    try {
                        $variant_id = decrypt($request->variant_id);
                        $variant = $product->variants()->find($variant_id);
                        if (!$variant) {
                            return redirect()->back()->with(['error' => 'Varian produk tidak ditemukan.']);
                        }
                        $price = $variant->price; // ambil harga dari varian
                    } catch (\Exception $e) {
                        return redirect()->back()->with(['error' => 'Varian tidak valid.']);
                    }
                }

                $cartQuery = Cart::where('product_id', $product->id)
                    ->where('user_id', Auth::id());

                if ($product->type == 2) {
                    $cartQuery->where('product_variant_id', $variant_id);
                }

                $cart = $cartQuery->first();
                if ($cart) {
                    $cart->qty += $request->quantity;
                    $cart->subtotal = $cart->qty * $cart->price;
                    $cart->save();
                } else {
                    Cart::create([
                        'user_id'    => Auth::id(),
                        'product_id' => $product->id,
                        'product_variant_id' => $variant_id,
                        'price'      => $price, 
                        'qty'        => $request->quantity,
                        'subtotal'   => $request->quantity * $price,
                    ]);
                }
            }

            return redirect()->route(
                'frontend.product.category', 
                ['category' => $product->category->slug, 'product' => $product->slug]
            )->with('success', 'Produk berhasil ditambahkan ke keranjang!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['cart' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $cart = Cart::where('id', $id)->first();

            if (!$cart) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Produk tidak ada di keranjang!'
                ]);
            }

            $cart->delete();

            // Hitung ulang total cart user
            $carts = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $total = (float)$carts->sum('subtotal');
            $count = (int)$carts->sum('qty');

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil dihapus dari keranjang!',
                'total'   => number_format($total, 0, ',', '.'),
                'count'   => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan!',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cart = Cart::where('id', $id)->first();

            if (!$cart) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Produk tidak ada di keranjang!'
                ]);
            }
            $subtotal = $cart->price * $request->quantity;

            $cart->update(['qty' => $request->quantity, 'subtotal' => $subtotal]);

            // Hitung ulang total cart user
            $carts = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $total = (float)$carts->sum('subtotal');
            $count = (int)$carts->sum('qty');

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil diperbarui!',
                'total'   => number_format($total, 0, ',', '.'),
                'count'   => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan!',
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $transactions = Transaction::where('user_id', $userId);

        $transaction = [
            'total_transaction' => (clone $transactions)->count(),
            'total_on_process' => (clone $transactions)->where('status', 1)->count(),
            'total_transaction_success' => (clone $transactions)->where('status', 2)->count(),
        ];
        $latestTransactions = $transactions->latest()->limit(5)->get();

        return view('frontend.dashboard.index', compact('transaction', 'latestTransactions'));
    }
    
    public function myOrder()
    {
        $userId = Auth::user()->id;
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('transactions.created_at', 'desc')->get();

        return view('frontend.dashboard.my-order', compact('transactions'));
    }
    
    public function wishlist()
    {
        $userId = Auth::user()->id;
        $wishlists = Wishlist::with([
            'product' => function ($q) {
                $q->with('category');
            }
        ])->where('user_id', $userId)->get();

        return view('frontend.dashboard.wishlist', compact('wishlists'));
    }

    
    public function changePassword()
    {
        return view('frontend.dashboard.change-password');
    }
    
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', 
        ]);
        $validator->validate();

        try {
            $user = User::findOrFail(Auth::id());

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with(['error' => 'Password lama tidak sesuai.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            return redirect()->route('frontend.dashboard.change-password')->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('frontend.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'address' => 'required',
        ]);
        $validator->validate();
        try {
            $user = User::findOrFail(Auth::id());
            $user->update([
                'email' => $request->email,
                'address' => $request->address,
                'name' => $request->name,
                'phone' => $request->phone
            ]);
            
            return redirect()->route('frontend.dashboard.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    
    public function paymentUpload(Request $request)
    {
        $fileSize = 1024 * 2;
        $validator = Validator::make($request->all(), [
            'file' => "required|image|mimes:jpg,jpeg,svg,png|max:$fileSize"     
        ]);

        if ($validator->fails()) {
            return redirect()->route('frontend.dashboard.my-order')->with('error', 'Bukti bayar gagal diupload!'); 
        }

        try {
            $id = decrypt($request->id);
            $data = Transaction::findOrFail($id);
            $param = ['remark' => $request->remark ?? ''];
            
            $file = $data->file;
            if($request->hasFile('file'))
            {
                if(isset($file) && file_exists(public_path($file)))
                {
                    unlink(public_path($file)); 
                    $file = $request->file('file');
                    $fileName = 'bukti-bayar-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/payment';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);
                } else {
                    $file = $request->file('file');
                    $fileName = 'bukti-bayar-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/payment';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);
                }
                $param['file'] = $base_path .'/'.$fileName;
            }
            $data->update($param);

            return redirect()->route('frontend.dashboard.my-order')->with('success', 'Bukti bayar berhasil diupload!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('frontend.dashboard.my-order')->with('error', 'Bukti bayar gagal diupload!');
        }
    }

    public function productPaid()
    {
        $userId = Auth::user()->id;
        $products = TransactionItem::with(['product', 'transaction'])
            ->whereHas('transaction', function ($q) {
                $q->where('user_id', Auth::id())
                ->where('status', 2);
            })
            ->select('product_id', 'transaction_id')
            ->groupBy('product_id', 'transaction_id')
            ->get()
            ->map(function ($item) {
                return [
                    'product' => $item->product,
                    'transaction_updated_at' => $item->transaction->updated_at ?? null
                ];
            });

        return view('frontend.dashboard.product-paid', compact('products'));
    }

}

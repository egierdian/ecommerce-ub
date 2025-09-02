<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
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
        $transactions = Transaction::where('user_id', $userId)->get();

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
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            return redirect()->route('frontend.dashboard.change-password')->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}

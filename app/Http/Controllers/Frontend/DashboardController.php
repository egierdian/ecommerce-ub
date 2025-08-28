<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'total_on_process' => (clone $transactions)->where('status', 0)->count(),
            'total_transaction_success' => (clone $transactions)->count(),
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
}

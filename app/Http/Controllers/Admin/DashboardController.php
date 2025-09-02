<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user')->latest()->limit(5)->get();

        $total_order = Transaction::count();

        $total_revenue = Transaction::where('status', 2)->sum('total');

        $total_customer = User::where('role', 'customer')->count();
        
        $top_products = DB::table('transaction_items as a')
            ->selectRaw('SUM(a.qty) as sold, b.name as product_name')
            ->leftJoin('products as b', 'b.id', '=', 'a.product_id')
            ->leftJoin('transactions as c', 'c.id', '=', 'a.transaction_id')
            ->where('c.status', 2)
            ->groupBy('a.product_id', 'b.name')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();


        return view('cms.dashboard.index', compact('transactions', 'total_order', 'total_revenue', 'total_customer', 'top_products'));
    }
}
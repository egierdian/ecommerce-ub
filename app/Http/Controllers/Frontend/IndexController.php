<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
                'products' => function ($query) {
                    $query->limit(20)->with('firstImage');
                }
            ])->where('status', 1)->get();

        $products = Product::with('firstImage')->where('status', 1)->limit(20)->get();
       
        return view('frontend.index', compact('categories','products'));
    }
}
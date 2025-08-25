<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
                'products' => function ($query) {
                    $query->limit(10)->with('firstImage');
                }
            ])->where('status', 1)->get();

        $products = Product::with('category','firstImage')->where('status', 1)->limit(10)->get();

        $sliders = Slider::where('status', 1)->get();
       
        return view('frontend.index', compact('categories','products','sliders'));
    }

    public function showProduct(Request $request, $category, $product = null)
    {
        if($product) {
            $product = Product::with('category','images')->where('status', 1)->where('slug', $product)->first();
            
            if(!$product) return redirect()->route('frontend.index');

            return view('frontend.pages.product-detail', compact('product'));
        } else {
            $dataCategory = null;
            $search = null;
            $query = Product::with(['firstImage', 'category'])
                ->select('products.*')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.status', 1);
            
            if($category == 'all') {
                $search = $request->query('q');
                if($search){
                    $query->where('products.name', 'like', '%' . $search . '%');
                }
            } else {
                $dataCategory = Category::where('status', 1)->where('slug', $category)->first();

                if(!$dataCategory) return redirect()->route('frontend.index');
                
                $query->where('categories.slug', $category);
            }
            $products = $query->paginate(10);

            return view('frontend.pages.product-category', compact('products','dataCategory','search'));
        }
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->limit(10)->with('firstImage');
            }
        ])->where('status', 1)->get();

        $products = Product::with('category', 'firstImage')->where('status', 1)->limit(10)->get();

        $sliders = Slider::where('status', 1)->get();

        return view('frontend.index', compact('categories', 'products', 'sliders'));
    }

    public function toggle($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'status'  => false,
                'message' => 'Silahkan login terlebih dahulu!'
            ]);
        }
        try {
            $productId = decrypt($productId);
            $userId = Auth::user()->id;

            $exists = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->exists();

            if ($exists) {
                Wishlist::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
                $message = 'Produk dihapus dari wishlist';
            } else {
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);
                $message = 'Produk ditambahkan ke wishlist';
            }
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan!',
            ]);
        }
    }
}

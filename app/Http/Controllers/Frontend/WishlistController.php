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
        if (!Auth::check()) {
            return redirect()->route('frontend.index');
        }
        $wishlists = Wishlist::with([
            'product' => function ($q) {
                $q->with('firstImage');
            }
        ])->where('user_id', Auth::id())->paginate(10);

        return view('frontend.pages.wishlist', compact('wishlists'));
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

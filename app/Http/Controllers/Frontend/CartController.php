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
        $id = decrypt($id);
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
        ]);
        $validator->validate();

        try {
            $product = Product::with('category')->where('status', 1)->where('id', $id)->first();

            $cart = Cart::where('product_id', $product->id)->first();

            if ($cart) {
                $cart->qty += $request->quantity;
                $cart->subtotal = $cart->qty * $cart->price;
                $cart->save();
            } else {
                Cart::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $product->id,
                    'price'      => $product->price,
                    'qty'        => $request->quantity,
                    'subtotal'   => $request->quantity * $product->price,
                ]);
            }

            return redirect()->route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])->with('success', 'Success add to cart!');
        } catch (\Exception $e) {
            // dd($e->getMessage());
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
                    'message' => 'Cart tidak ditemukan!'
                ], 404);
            }

            $cart->delete();

            // Hitung ulang total cart user
            $carts = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $total = $carts->sum(fn($c) => $c->product->price * $c->qty);
            $count = $carts->sum('qty');

            return response()->json([
                'status'  => true,
                'message' => 'Cart berhasil dihapus!',
                'total'   => number_format($total, 0, ',', '.'),
                'count'   => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan!',
            ], 500);
        }
    }
}

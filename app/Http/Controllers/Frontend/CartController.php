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
        if($request->type != 1) {
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

            $total = $carts->sum(fn($c) => $c->product->price * $c->qty);
            $count = $carts->sum('qty');

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
}

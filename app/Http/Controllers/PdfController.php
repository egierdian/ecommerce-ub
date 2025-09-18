<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfController extends Controller
{
    public function stream(Request $request, $product_id = null)
    {
        try {
            $id = decrypt($product_id);

            $product = Product::find($id);

            if (!$product) {
                abort(403, 'Forbidden');
            }

            $path = public_path($product->file);
            $file = 'filePdf';

            // langsung cek apakah product_id ini memang dibayar user
            $isPaid = TransactionItem::where('product_id', $product->id)
                ->whereHas('transaction', function ($q) {
                    $q->where('user_id', Auth::id())
                        ->where('status', 2);
                })
                ->exists();

            if (!$isPaid) {
                abort(403, 'Forbidden');
            }

            if (!file_exists($path)) {
                abort(403, 'Forbidden');
            }
            
            if ($request->pdf_token !== session('pdf_token')) {
                abort(403, 'Invalid or expired link.');
            }

            session()->forget('pdf_token');

            return new StreamedResponse(function () use ($path) {
                $stream = fopen($path, 'rb');
                fpassthru($stream);
                fclose($stream);
            }, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $file . '"',
                'Cache-Control'       => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma'              => 'no-cache',
            ]);
        } catch (\Exception $e) {
            abort(403, 'Forbidden');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::query()
                ->select('transactions.*', 'users.name as customer_name', 'users.email as customer_email')
                ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                ->latest();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->customer_name . ' (' . $row->customer_email . ')';
                })
                ->addColumn('total', function ($row) {
                    return 'Rp ' . number_format($row->total, 0, ',', '.');
                })
                ->addColumn('status', function ($row) {
                    return paymentStatusBadge($row->status);
                })
                ->addColumn('created_at', function ($row) {
                    return date('Y-m-d', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $btnApprove = '';
                    $btnReject = '';
                    $btnDetail = "<a href='".route('admin.transaction.detail', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none m-1'><i class='fa fa-eye' data-toggle='tooltip' data-placement='top' title='Detail'></i></a>";
                    if ($row->status == 1) {
                        $btnApprove = "<a href='javascript:void(0)' class='text-success text-decoration-none m-1' data-toggle='tooltip' data-placement='top' title='Approve'><i class='fa fa-check' title='Delete' onclick='approval(this)' data-id='".encrypt($row->id)."' data-code='$row->code' data-status='2'></i></a>";
                        $btnReject = "<a href='javascript:void(0)' class='text-danger text-decoration-none m-1' data-toggle='tooltip' data-placement='top' title='Reject'><i class='fa fa-times' title='Delete' onclick='approval(this)' data-id='".encrypt($row->id)."' data-code='$row->code' data-status='3'></i></a>";
                    }

                    return $btnDetail . $btnApprove . $btnReject;
                })
                ->addColumn('file', function ($row) {
                    if($row->file) return '<a href="'.asset($row->file).'" target="_blank">Lihat</a>';
                    return '';
                })
                ->filterColumn('customer', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('users.name', 'like', "%{$keyword}%")
                            ->orWhere('users.email', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE(transactions.created_at) like ?", ["%$keyword%"]);
                })
                ->rawColumns(['action', 'status','file'])
                ->make(true);
        }
        return view('cms.transaction.index');
    }
    public function approval(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:2,3'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $transaction = Transaction::findOrFail($id);

            $transaction->update([
                'status' => $request->status
            ]);

            if ($request->status == 2) {
                $transactionItems = TransactionItem::where('transaction_id', $id)->get();

                foreach ($transactionItems as $item) {
                    $product = Product::findOrFail($item->product_id);

                    if($product->type != 1) {
                        if ($product->qty < $item->qty) {
                            throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                        }

                        $product->decrement('qty', $item->qty);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.transaction')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    
    public function detail($id)
    {
        $transaction = Transaction::with(['transactionItems.product'])->findOrFail(decrypt($id));

        return view('cms.transaction.detail', compact('transaction'));
    }
}

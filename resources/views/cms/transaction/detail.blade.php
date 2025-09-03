@extends('cms.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<div class="page-inner">

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Informasi Transaksi</h4>
                </div>
                <div class="card-body">
                    <p><strong>Kode Transaksi:</strong> {{ $transaction->code }}</p>
                    <p><strong>Tanggal:</strong> {{ date('d M Y H:i', strtotime($transaction->created_at)) }}</p>
                    <p><strong>Status:</strong> 
                        {!! paymentStatusBadge($transaction->status) !!}
                    </p>
                    <p><strong>Pelanggan:</strong> {{ $transaction->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Produk --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Produk yang Dibeli</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->transactionItems as $i => $item)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Total</td>
                                    <td class="font-weight-bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-action text-right">
                    <a href="{{ route('admin.transaction') }}" class="btn btn-info">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

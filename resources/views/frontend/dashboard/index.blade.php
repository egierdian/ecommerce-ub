@extends('frontend.dashboard.master')

@section('title', 'Dashboard Pembeli')

@section('dashboard-content')
<h2 class="mb-4">Dashboard Pembeli</h2>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <h5>Total Pesanan</h5>
            <p class="fs-3 fw-bold text-primary">{{$transaction['total_transaction']}}</p>
            <span class="text-muted">Semua transaksi</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <h5>Pesanan Diproses</h5>
            <p class="fs-3 fw-bold text-primary">{{$transaction['total_on_process']}}</p>
            <span class="text-muted">Menunggu persetujuan</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <h5>Pesanan Selesai</h5>
            <p class="fs-3 fw-bold text-success">{{$transaction['total_transaction_success']}}</p>
            <span class="text-muted">Pesanan berhasil</span>
        </div>
    </div>
</div>

<div class="mt-5">
    <h4>Riwayat Pesanan Terbaru</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Bukti Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestTransactions as $trans)
                <tr>
                    <td>{{$trans->code}}</td>
                    <td>{{date('d M Y', strtotime($trans->created_at))}}</td>
                    <td>
                        {!! paymentStatusBadge($trans->status) !!}
                    </td>
                    <td>Rp {{number_format($trans->total, 0, ',', '.')}}</td>
                    <td>
                        @if($trans->file)
                        <a href="{{asset($trans->file)}}" target="_blank">Lihat</a>
                        @endif
                    </td>
                    <td><a href="{{route('frontend.invoice', ['code' => $trans->code])}}" class="btn btn-sm btn-primary" target="_blank">Invoice</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
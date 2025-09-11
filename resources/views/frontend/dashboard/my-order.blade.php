@extends('frontend.dashboard.master')

@section('title', 'Pesanan Saya')

@section('dashboard-content')

<div>
    <h4>Riwayat Pesanan</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trans)
                <tr>
                    <td>{{$trans->code}}</td>
                    <td>{{date('d M Y', strtotime($trans->created_at))}}</td>
                    <td>
                        {!! paymentStatusBadge($trans->status) !!}
                    </td>
                    <td>Rp {{number_format($trans->total, 0, ',', '.')}}</td>
                    <td><a href="{{route('frontend.invoice', ['code' => $trans->code])}}" class="btn btn-sm btn-primary" target="_blank">Invoice</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@extends('frontend.dashboard.master')

@section('title', 'Produk Terbeli')

@section('dashboard-content')

<div>
    <h4 class="mb-3">Produk Dibeli</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Beli</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    <td>{{$item['product']->name}}</td>
                    <td>{{date('d M Y', strtotime($item['transaction_updated_at']))}}</td>
                    <td>
                        @if($item['product']->file && $item['product']->type == '3')
                        <a href="{{route('frontend.read-book', ['slug' => $item['product']->slug])}}" target="_blank">Baca</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
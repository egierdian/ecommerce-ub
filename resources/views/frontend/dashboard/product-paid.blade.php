@extends('frontend.dashboard.master')

@section('title', 'Produk Terbeli')

@section('dashboard-content')

<div>
    <h4>Produk dibeli</h4>
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
                @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{date('d M Y', strtotime($product->created_at))}}</td>
                    <td>
                        @if($product->file)
                        <a href="{{route('frontend.read-book', ['slug' => $product->slug])}}" target="_blank">Baca</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
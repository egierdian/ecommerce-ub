@extends('frontend.dashboard.master')

@section('title', 'Pesanan Saya')

@section('dashboard-content')

<div>
    <h4>Wishlist</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wishlists as $wishlist)
                <tr>
                    <td>{{$wishlist->product->name}}</td>
                    <td>{{date('d M Y', strtotime($wishlist->created_at))}}</td>
                    <td><a href="{{route('frontend.product.category', ['category' => $wishlist->product->category->slug, 'product' => $wishlist->product->slug])}}" class="btn btn-sm btn-primary" target="_blank">Lihat</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
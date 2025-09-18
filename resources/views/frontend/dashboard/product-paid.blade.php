@extends('frontend.dashboard.master')

@section('title', 'Produk Terbeli')

@section('dashboard-content')

<div>
    @if(session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center" id="successAlert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h4 class="mb-3">Produk Dibeli</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
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
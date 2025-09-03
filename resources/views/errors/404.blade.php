@extends('frontend.layouts.master')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-3 fw-bold">404</h1>
                <p class="fs-4 mb-4">Oops! Halaman yang kamu cari tidak ditemukan.</p>
                <a href="{{ url()->previous() ?? url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection
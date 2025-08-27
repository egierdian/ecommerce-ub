@extends('frontend.layouts.master')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center text-center" style="height:80vh;">
    <h1 class="display-3 fw-bold">404</h1>
    <p class="fs-4 mb-4">Oops! Halaman yang kamu cari tidak ditemukan.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection

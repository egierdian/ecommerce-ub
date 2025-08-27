@extends('frontend.layouts.master') {{-- kalau kamu punya layout utama --}}

@section('title', 'Akses Ditolak')

@section('content')
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-3 fw-bold">403</h1>
                <p class="fs-4 mb-4">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection

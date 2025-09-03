@extends('frontend.layouts.master')

@section('title', 'Kontak kami')

@section('style')
<style>
</style>
@endsection

@section('content')
<!-- Hero -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-primary">Hubungi Kami</h1>
        <p class="lead text-muted">Kami siap membantu pertanyaan dan kebutuhan Anda</p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card shadow h-100">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-4">Informasi Kontak</h4>
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary fs-6">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <p class="mb-0">{{$webSettings['address']??''}}</p>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary fs-6">
                                <i class="fas fa-phone"></i>
                            </div>
                            <p class="mb-0">{{$webSettings['contact_phone']??''}}</p>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary fs-6">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <p class="mb-0">{{$webSettings['contact_email']??''}}</p>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="me-3 text-primary fs-6">
                                <i class="fas fa-clock"></i>
                            </div>
                            <p class="mb-0">Senin - Minggu: 08.00 - 20.00</p>
                        </div>


                        <h5 class="fw-bold text-primary mb-3">Ikuti Kami</h5>
                        <div class="d-flex gap-3 fs-4">
                            <a href="{{$webSettings['facebook']??''}}" class="text-primary"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{$webSettings['instagram']??''}}" class="text-primary"><i class="fab fa-instagram"></i></a>
                            <a href="{{$webSettings['linkedin']??''}}" class="text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="{{$webSettings['youtube']??''}}" class="text-primary"><i class="fab fa-youtube"></i></a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-7">
                <div class="card shadow h-100">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-4">Kirim Pesan</h4>
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" id="subject" name="subject" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send-fill me-2"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Map -->
<section class="pb-5">
    <div class="container">
        <div class="card shadow overflow-hidden">
            <iframe src="{{$webSettings['maps']??''}}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
@endsection
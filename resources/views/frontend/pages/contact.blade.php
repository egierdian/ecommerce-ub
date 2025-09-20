@extends('frontend.layouts.master')

@section('title', 'Kontak kami')

@section('style')
<style>
    .fa-tiktok {
        display: inline-block;
        width: 0.8em;
        /* ikut font-size */
        height: 0.8em;
        background: url('/frontend/images/icon/tiktok.svg') no-repeat center;
        background-size: contain;
        /* biar fit */
        vertical-align: middle;
        /* biar sejajar teks */
        margin-top: -5px;
    }
</style>
@endsection

@section('content')
<!-- Hero -->
<section class=" py-5">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary">Hubungi Kami</h1>
        <p class="lead text-muted">Kami siap membantu pertanyaan dan kebutuhan Anda</p>
    </div>
</section>

<section class="pb-5">
    <div class="container-fluid">
        <div class="bg-info py-5 rounded-5" style="background: url('{{ asset('frontend/images/bg-leaves-img-pattern.png') }}') no-repeat;">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-5 p-5">
                        <h4 class="fw-bold text-primary mb-4">Informasi Kontak</h4>
                        <div class="d-grid gap-2" style="grid-template-columns: 30px auto;">
                            <div class="text-primary fs-6 text-center"><i class="fas fa-map-marker-alt"></i></div>
                            <div>{{$webSettings['address'] ?? ''}}</div>

                            <div class="text-primary fs-6 text-center"><i class="fas fa-phone"></i></div>
                            <div>{{$webSettings['contact_phone'] ?? ''}}</div>

                            <div class="text-primary fs-6 text-center"><i class="fas fa-envelope"></i></div>
                            <div>{{$webSettings['contact_email'] ?? ''}}</div>

                            <div class="text-primary fs-6 text-center"><i class="fas fa-clock"></i></div>
                            <p class="mb-0">Senin - Minggu: 08.00 - 20.00</p>
                        </div>

                        <h5 class="fw-bold text-primary mb-2 mt-4">Follow us on</h5>
                        <div class="d-flex gap-3 fs-4">
                            <!-- <a href="{{$webSettings['facebook']??''}}" class="text-primary"><i class="fab fa-facebook-f"></i></a> -->
                            <a href="{{$webSettings['instagram']??''}}" class="text-primary"><i class="fab fa-instagram"></i></a>
                            <a href="{{$webSettings['linkedin']??''}}" class="text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="{{$webSettings['youtube']??''}}" class="text-primary"><i class="fab fa-youtube"></i></a>
                            <a href="{{$webSettings['tiktok']??''}}" class="text-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" style="margin-top: -5px"
                                    viewBox="0 0 448 512" fill="currentColor">
                                    <path d="M448,209.91c-17.55,0-34.48-2.06-50.86-5.93V358.4
                                                c0,84.18-68.28,152.46-152.46,152.46S92.22,442.58,92.22,358.4
                                                c0-71.28,48.94-131.28,115.46-148.17v79.94
                                                c-22.26,10.14-37.72,32.61-37.72,58.23
                                                c0,35.67,28.91,64.58,64.58,64.58s64.58-28.91,64.58-64.58V0h84.18
                                                c0,69.28,56.12,125.46,125.46,125.46V209.91z" />
                                </svg></a>
                        </div>

                    </div>
                    <div class="col-md-6 p-5">
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control form-control-lg" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" id="subject" name="subject" class="form-control form-control-lg">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea id="message" name="message" rows="5" class="form-control form-control-lg" required></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-lg">Submit</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>
<!-- Map -->
<section class="pb-5">
    <div class="overflow-hidden">
        <iframe src="{{$webSettings['maps']??''}}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
@endsection
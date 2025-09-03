@extends('frontend.layouts.master')

@section('title', 'Tentang kami')

@section('style')
<style>
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-primary">Tentang {{$webSettings['title_website']??''}}</h1>
        <p class="lead text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit necessitatibus aspernatur qui consectetur fuga officia voluptas nihil odio, voluptatum numquam magni eaque, omnis, voluptatibus pariatur dolorem facere temporibus voluptatem blanditiis?</p>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <img src="https://source.unsplash.com/600x400/?grocery,vegetables" 
                     alt="Foodmart Fresh" class="img-fluid rounded-3 shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold text-primary mb-3">Siapa Kami?</h2>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo fugit perferendis ratione blanditiis porro exercitationem saepe expedita. Accusamus, animi, eos iste excepturi at autem quo iusto, delectus ducimus enim placeat?
                </p>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, dolorem quidem nulla, soluta enim voluptatem quo dignissimos voluptates illo, reiciendis impedit accusamus deleniti similique suscipit excepturi odio et pariatur eos.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="bg-info text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Misi & Visi Kami</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 bg-white text-dark rounded-4 shadow h-100">
                    <h4 class="fw-bold text-primary">Misi</h4>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia voluptas officiis molestias doloribus quidem non, quaerat in molestiae recusandae necessitatibus ipsum fuga voluptates cupiditate debitis nesciunt aut quos assumenda temporibus?</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white text-dark rounded-4 shadow h-100">
                    <h4 class="fw-bold text-primary">Visi</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum beatae dolore saepe tempore ab nobis, nesciunt, incidunt quasi, dolorum aspernatur quo perspiciatis atque earum esse maiores? Sunt eligendi maiores dolorem.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center text-primary mb-5">Tim {{$webSettings['title_website']??''}}</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-sm-6">
                <div class="card shadow border-0 rounded-4">
                    <img src="https://source.unsplash.com/400x400/?person,chef" class="card-img-top rounded-top-4" alt="CEO">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Andi Saputra</h5>
                        <p class="text-muted">CEO & Founder</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card shadow border-0 rounded-4">
                    <img src="https://source.unsplash.com/400x400/?woman,entrepreneur" class="card-img-top rounded-top-4" alt="COO">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Siti Rahmawati</h5>
                        <p class="text-muted">COO</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold text-primary mb-3">Belanja Mudah, Hidup Sehat</h2>
        <p class="text-muted mb-4">Temukan berbagai kebutuhan pangan segar hanya di Foodmart</p>
        <a href="{{ route('frontend.index') }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow">
            Mulai Belanja
        </a>
    </div>
</section>
@endsection

@extends('frontend.layouts.master')

@section('title', 'FAQ')

@section('style')
<style>
    /* FAQ Card */
    .faq-card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        background: #fff;
    }

    .faq-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.12);
    }

    /* Header */
    .faq-card .card-header {
        background: #f2f2f2;
        border: none;
        font-weight: 600;
        font-size: 1.1rem;
        color: #212529;
        cursor: pointer;
        padding: 1.1rem 1.25rem;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-card .card-header:hover {
        background: #f8f9fa;
    }

    /* Body */
    .faq-card .card-body {
        background: #fff;
        color: #495057;
        font-size: 0.96rem;
        line-height: 1.6;
        /* border-left: 4px solid #0d6efd; */
        padding: 1.2rem 1.25rem;
        animation: fadeSlide 0.35s ease;
    }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Icon toggle */
    .faq-icon {
        font-size: 1rem;
        color: #0d6efd;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .faq-card .collapsed .faq-icon::before {
        content: "\f067"; /* Font Awesome plus */
    }

    .faq-card .card-header[aria-expanded="true"] .faq-icon::before {
        content: "\f068"; /* Font Awesome minus */
        color: #dc3545;
    }

    /* Search Box */
    .faq-search {
        max-width: 500px;
        margin: 0 auto 2rem auto;
        position: relative;
    }

    .faq-search input {
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        padding-left: 2.75rem;
        border: 1px solid #ced4da;
        box-shadow: none;
    }

    .faq-search i {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: #6c757d;
    }
</style>
@endsection

@section('content')

<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-primary">Frequently Asked Questions</h1>
        <p class="lead text-muted">
            Temukan jawaban atas pertanyaan yang sering ditanyakan, atau gunakan kolom pencarian di bawah ini.
        </p>

        <!-- Search Box -->
        <div class="faq-search">
            <i class="fa fa-search"></i>
            <input type="text" id="faqSearch" class="form-control" placeholder="Cari pertanyaan...">
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @foreach($faqs as $k => $faq)
                <!-- FAQ -->
                <div class="card faq-card mb-3 shadow-sm">
                    <a class="card-header text-decoration-none collapsed"
                        data-bs-toggle="collapse" href="#faq{{$faq->id}}" role="button"
                        aria-expanded="{{$k == 0 ? 'true' : 'false'}}">
                        <span>{{$faq->title}}</span>
                        <i class="faq-icon fas"></i>
                    </a>
                    <div id="faq{{$faq->id}}" class="collapse {{$k == 0 ? 'show' : ''}}">
                        <div class="card-body">
                            {!! $faq->description !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#faqSearch").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $(".faq-card").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection

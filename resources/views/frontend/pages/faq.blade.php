@extends('frontend.layouts.master')

@section('title', 'Invoice')

@section('style')
<style>
</style>
@endsection

@section('content')

<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-primary">Frequently Asked Questions</h1>
        <p class="lead text-muted">Temukan jawaban dari pertanyaan yang sering ditanyakan, atau hubungi tim kami bila masih ada yang ingin ditanyakan.</p>
    </div>
</section>

<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        @foreach($faqs as $k => $faq)
                        <!-- FAQ 1 -->
                        <div class="card mb-3 shadow-sm">
                            <a class="card-header d-flex justify-content-between align-items-center text-decoration-none"
                                data-bs-toggle="collapse" href="#faq{{$faq->id}}" role="button">
                                <span>{{$faq->title}}</span>
                                <i class="fa fa-chevron-down"></i>
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
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        console.log('test')
    })
</script>
@endsection
@extends('frontend.layouts.master')

@section('title', 'Checkout success')

@section('style')
<style>
    .card {
        border: none;
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.04) 0px 5px 22px;
        margin-bottom: 30px;
        padding: 16px;
        background: rgb(255, 255, 255);
        border-width: 1px;
        border-style: solid;
        border-color: rgb(251, 251, 251);
        border-image: initial;
        border-radius: 16px;
    }

    .card-header {
        background: #fff;
        border-bottom: none;
        font-weight: bold;
        font-size: 18px;
        padding: 1.2rem;
    }

    .form-control,
    .list-group-item {
        border-radius: 10px;
    }

    .btn-custom-primary {
        border-radius: 12px;
        padding: 14px;
        font-size: 18px;
        font-weight: 600;
    }

    .cart-summary li {
        border: none !important;
        padding: 0.75rem 0;
    }

    .cart-summary li:not(:last-child) {
        border-bottom: 1px solid #eee !important;
    }

    .total-row {
        font-size: 20px;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="mb-3">
                        <span style="font-size:50px;">✅</span>
                    </div>
                    <h4 class="mb-3">Pesanan Berhasil!</h4>
                    <p>Terima kasih, pesanan Anda berhasil dibuat.</p>
                    <p>Anda akan diarahkan ke halaman invoice dalam <span id="countdown">3</span> detik.</p>
                    <a href="{{ route('frontend.invoice', ['code' => $code]) }}" class="btn btn-primary mt-3">
                        Lihat Invoice Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        let seconds = 3;
        let countdown = document.getElementById("countdown");

        let interval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('frontend.invoice', ['code' => $code]) }}";
            }
        }, 1000);

    })
</script>
@endsection
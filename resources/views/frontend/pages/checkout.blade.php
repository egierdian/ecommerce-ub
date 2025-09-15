@extends('frontend.layouts.master')

@section('title', 'Checkout')

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

    .btn-primary {
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

<section class="py-3">
    <div class="container-fluid">
        @if(session('error'))
        <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{route('frontend.checkout.process')}}" method="POST">
            <div class="row g-4">
                <!-- Form -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">📦 Informasi Pengiriman</div>
                        <div class="card-body">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control" name="name"
                                        value="{{Auth::user()->name }}" required>
                                    @error('name')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control form-control" name="phone"
                                        value="{{Auth::user()->phone }}" required>
                                    @error('phone')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control form-control" rows="3"
                                        placeholder="Jl. Contoh No.123, Jakarta"
                                        name="address" required>{{Auth::user()->address }}</textarea>
                                    @error('address')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- <div class="col-md-6">
                                    <label class="form-label">Kota</label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="Jakarta" name="city" required>
                                    @error('city')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="12345" name="postal_code" maxlength="5" required>
                                    @error('postal_code')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div> -->
                            </div>
                            <div class="mt-5">
                                <h5 class="mb-3">💳 Metode Pembayaran</h5>
                                <div class="list-group">
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Transfer Bank</span>
                                        <input class="form-check-input" type="radio" name="payment_method" value="1" required checked>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>E-Wallet (OVO, Gopay, Dana)</span>
                                        <input class="form-check-input" type="radio" name="payment_method" value="2" required>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>COD (Bayar di Tempat)</span>
                                        <input class="form-check-input" type="radio" name="payment_method" value="3" required>
                                    </label>
                                </div>

                                <!-- Info pembayaran -->
                                <div id="payment-info" class="mt-3 p-3 border rounded bg-light">
                                    <p class="mb-1 fw-bold">Nomor Pembayaran:</p>
                                    <p class="mb-0" id="payment-detail">BCA - 1234567890 a.n Universitas Bakrie</p>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">🧾 Ringkasan Pesanan</div>
                        <div class="card-body">
                            <ul class="list-group cart-summary mb-3">
                                @foreach($checkoutCarts as $cart)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>
                                        <input type="hidden" name="carts[]" value="{{encrypt($cart->id)}}">
                                        <h6 class="my-0">{{$cart->product->name}} </h6>
                                        <span class='text-muted m-0'>{{$cart->product->type == 1 ? '('.$cart->start_date.' - '.$cart->end_date.')' : ''}}</span>
                                        <small class="text-muted">x{{$cart->qty}}</small>
                                    </div>
                                    <span>Rp {{number_format($cart->subtotal, 0, ',', '.')}}</span>
                                </li>
                                @endforeach
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong>Rp {{number_format($totalPrice, 0, ',', '.')}}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Ongkir</span>
                                    <strong>Rp 0</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between total-row">
                                    <span>Total</span>
                                    <span>Rp {{number_format($totalPrice + 0, 0, ',', '.')}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const paymentDetail = document.getElementById('payment-detail');

        const paymentMethods = {
            1: "BCA - 1234567890 a.n Universitas Bakrie",
            2: "OVO/Gopay/Dana - 0812 3456 7890 a.n Universitas Bakrie",
            3: "Bayar langsung ke kurir saat barang diterima"
        };

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                paymentDetail.textContent = paymentMethods[this.value];
            });
        });
    })
</script>
@endsection
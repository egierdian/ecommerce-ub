@extends('frontend.layouts.master')

@section('title', $product->name??'')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
  .card {
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

  .card .thumb-img {
    cursor: pointer;
    max-height: 100px;
    object-fit: cover;
    border: 2px solid transparent;
    border: 1px solid rgba(0, 0, 0, 0.5);
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    /* biar ada kontras */
    border-radius: 50%;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
    /* shadow biar jelas */
    background-size: 60% 60%;
    /* kecilin icon biar pas */
  }

  .thumbnails {
    margin: 0 8px;
  }

  .section-add-cart {
    display: flex;
    align-items: center;
    border-top: 1px solid #F7F7F7;
    margin-top: 10px;
    padding-top: 10px;
  }

  .section-add-cart .product-qty {
    width: 85px;
  }

  .section-add-cart #quantity {
    height: auto;
    width: 28px;
    text-align: center;
    border-width: initial;
    border-style: none;
    border-color: initial;
    border-image: initial;
    margin: 0px;
    padding: 0px;
  }

  .section-add-cart .btn-number {
    width: 26px;
    height: 26px;
    line-height: 1;
    text-align: center;
    background: #FFFFFF;
    border: 1px solid #E2E2E2;
    border-radius: 6px;
    color: #222;
    padding: 0;
  }

  @media (max-width: 768px) {
    .section-add-cart {
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
  }
</style>
<section class="py-3">
  <div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center" id="successAlert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @error('quantity')
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card shadow-sm">
      <div class="card-body">

        <div class="row">
          <!-- Product Images -->
          <div class="col-md-6 mb-2">
            <!-- Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                @foreach($product->images as $k => $img)
                <div class="carousel-item {{$k == 0 ? 'active' : ''}} ">
                  <img src="{{asset($img->path)}}" class="d-block w-100" alt="{{$product->name}}">
                </div>
                @endforeach
              </div>
              <!-- Controls -->
              <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>

            <!-- Thumbnails -->
            <div class="mt-3" style="border: 2px solid #F7F7F7;padding: 10px 0">
              <div class="d-flex overflow-auto gap-2 p-1 thumbnails">
                @foreach($product->images as $k => $img)
                <img src="{{asset($img->path)}}"
                  class="thumb-img"
                  data-bs-target="#productCarousel"
                  data-bs-slide-to="{{$k}}">
                @endforeach
              </div>
            </div>
          </div>

          <!-- Product Details -->
          <div class="col-md-6 mb-2">
            <h2>{{$product->name}}</h2>
            <p>
              <span class="badge bg-secondary">
                <i class="bi bi-tag me-1"></i> {{$product->category->name}}
              </span>
              @if($product->type == 2)
              <span class="badge bg-dark">Stok tersedia: {{$product->qty - $pendingStock??0}}</span>
              @endif
            </p>

            @if($product->type == 1)
            <div class="card shadow-sm border-0 mb-3">
              <div class="card-header bg-primary text-white fw-bold">
                Harga Sewa per Jam
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col-7 col-md-8 text-muted">
                      <i class="bi bi-clock me-2"></i> Senin - Jumat (08.00 - 18.00)
                    </div>
                    <div class="col-5 col-md-4 text-end fw-bold text-primary">
                      Rp {{ number_format($product->base_price_per_hour, 0, ',', '.') }}
                      <small class="text-muted">/Jam</small>
                    </div>
                  </div>
                </li>

                <li class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col-7 col-md-8 text-muted">
                      <i class="bi bi-clock me-2"></i> Senin - Jumat (08.00 - 21.00)
                    </div>
                    <div class="col-5 col-md-4 text-end fw-bold text-primary">
                      Rp {{ number_format($product->holiday_price_per_hour, 0, ',', '.') }}
                      <small class="text-muted">/Jam</small>
                    </div>
                  </div>
                </li>

                <li class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col-7 col-md-8 text-muted">
                      <i class="bi bi-clock me-2"></i> Sabtu (08.00 - 18.00)
                    </div>
                    <div class="col-5 col-md-4 text-end fw-bold text-primary">
                      Rp {{ number_format($product->holiday_price_per_hour, 0, ',', '.') }}
                      <small class="text-muted">/Jam</small>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            @else
            <h4 class="price">Rp {{number_format($product->price, 0, ',', '.')}}</h4>
            @endif

            {!! $product->description !!}
            <form action="{{route('frontend.cart.add', ['productId' => encrypt($product->id)])}}" method="POST" class="flex items-center gap-2">
              @csrf
              <div class="section-add-cart">
                @if($product->type == 2)
                <div class="input-group product-qty" style="margin-right: 20px;">
                  <span class="input-group-btn">
                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                      <svg width="16" height="16">
                        <use xlink:href="#minus"></use>
                      </svg>
                    </button>
                  </span>
                  <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                  <span class="input-group-btn">
                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                      <svg width="16" height="16">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </button>
                  </span>
                </div>
                <button href="#" class="nav-link ml-2 mt-2" type="submit"><b>Tambahkan ke Keranjang</b></button>
                @else
                <p class="fw-bold">For more information please contact admin!</p>
                @endif
              </div>
            </form>
            <div class="mt-2" hidden>
              <button class="btn btn-primary">Pesan</button>
            </div>
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
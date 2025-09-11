@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<style>
  @media (max-width: 768px) {
    .tabs-header {
      flex-direction: column;
      /* ubah jadi vertikal */
      align-items: flex-start;
      /* optional: agar kiri rata */
    }

    .tabs-header nav {
      width: 100%;
      margin-top: 1rem;
    }

    .tabs-header .nav-tabs {
      flex-direction: row;
      justify-content: flex-start;
      width: 100%;
    }

    .tabs-header .nav-tabs .nav-link {
      flex: 0 0 auto;
      margin-right: .5rem;
      margin-bottom: 0;
    }
  }
</style>
@endsection

@section('content')
<section class="py-3" style="background-image: url('images/background-pattern.jpg');background-repeat: no-repeat;background-size: cover;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="banner-blocks">
          <div class="banner-ad large bg-info block-1">
            <div class="swiper main-swiper">
              <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                <div class="swiper-slide">
                  <div class="row banner-content p-5 align-items-center">
                    <div class="content-wrapper col-md-7">
                      <h3 class="display-4">{{$slider->title}}</h3>
                      <p>{{$slider->description}}</p>
                      <a href="{{$slider->url}}" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">More Detail</a>
                    </div>
                    <div class="img-wrapper col-md-5">
                      <img src="{{asset($slider->image)}}" class="img-fluid">
                    </div>
                  </div>
                </div>
                @endforeach
              </div>

              <div class="swiper-pagination"></div>

            </div>
          </div>

        </div>
        <!-- / Banner Blocks -->

      </div>
    </div>
  </div>
</section>

<section class="py-5 overflow-hidden">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="section-header d-flex flex-wrap justify-content-between mb-5">
          <h2 class="section-title">Kategori</h2>

          <div class="d-flex align-items-center">
            <a href="#" class="btn-link text-decoration-none">Lihat semua kategori →</a>
            <div class="swiper-buttons">
              <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
              <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-12">

        <div class="category-carousel swiper">
          <div class="swiper-wrapper">
            @foreach($categories as $category)
            <a href="{{route('frontend.product.category', ['category' => $category->slug])}}" class="nav-link category-item swiper-slide">
              <img src="{{asset($category->image)}}" alt="{{$category->name}}" width="50">
              <h3 class="category-title">{{$category->name}}</h3>
            </a>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">

        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header d-flex justify-content-between border-bottom my-5">
            <h3>Produk</h3>
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                @foreach($categories as $category)
                <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab" data-bs-toggle="tab" data-bs-target="#{{$category->slug}}">{{$category->name}}</a>
                @endforeach
              </div>
            </nav>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

                @foreach($products as $product)
                <div class="col">
                  <div class="product-item h-100 d-flex flex-column">
                    <span class="badge bg-success position-absolute m-3"></span>
                    <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{encrypt($product->id)}}">
                      <svg width="14" height="14">
                        <use xlink:href="{{ $product->wishlists->isNotEmpty() ? '#trash' : '#heart' }}"></use>
                      </svg>
                    </button>
                    <figure>
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" title="{{$product->name}}">
                        <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$product->name}}</h3>
                    <span class="product-category">{{$product->type=='1'?'Sewa':'Produk'}} - {{$product->category->name}}</span>
                    <div class="position-absolute bottom-0 start-0 end-0 p-3">
                      <span class="price fw-bold fs-5 text-primary">Rp {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-outline-primary btn-sm mt-2 w-100 fw-semibold">Lihat</a>
                    </div>
                  </div>
                </div>
                @endforeach

              </div>
              <div class="text-center mt-4">
                <a href="{{route('frontend.product.category', ['category' => 'all'])}}" class="btn btn-primary px-4 py-2">
                  Lihat Semua Produk
                </a>
              </div>
              <!-- / product-grid -->

            </div>

            @foreach($categories as $category)
            <div class="tab-pane fade" id="{{$category->slug}}" role="tabpanel" aria-labelledby="{{$category->slug}}-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @if(count($category->products) > 0)
                @foreach($category->products as $product)
                <div class="col">
                  <div class="product-item h-100 d-flex flex-column">
                    <span class="badge bg-success position-absolute m-3"></span>
                    <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{encrypt($product->id)}}"><svg width="14" height="14">
                        <use xlink:href="{{ $product->wishlists->isNotEmpty() ? '#trash' : '#heart' }}"></use>
                      </svg></button>
                    <figure>
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" title="{{$product->name}}">
                        <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$product->name}}</h3>
                    <span class="product-category">{{$product->type=='1'?'Sewa':'Produk'}} - {{$product->category->name}}</span>
                    <div class="position-absolute bottom-0 start-0 end-0 p-3">
                      <span class="price">Rp {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-outline-primary btn-sm mt-2 w-100 fw-semibold">Lihat</a>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                <div class="w-100 text-center">
                  Data tidak ditemukan
                </div>
                @endif
              </div>
              @if(count($category->products) > 0)
              <div class="text-center mt-4">
                <a href="{{route('frontend.product.category', ['category' => $category->slug])}}" class="btn btn-primary px-4 py-2">
                  Lihat Semua Produk {{$category->name}}
                </a>
              </div>
              @endif
              <!-- / product-grid -->

            </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- paling laku -->
<section class="py-5 overflow-hidden">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="section-header d-flex flex-wrap justify-content-between my-5">

          <h2 class="section-title">Produk Terlaris</h2>

          <div class="d-flex align-items-center">
            <a href="#" class="btn-link text-decoration-none"> →</a>
            <div class="swiper-buttons">
              <button class="swiper-prev products-carousel-prev btn btn-primary" tabindex="0" aria-label="Previous slide" aria-controls="swiper-wrapper-6197efd36115bc78" aria-disabled="false">❮</button>
              <button class="swiper-next products-carousel-next btn btn-primary swiper-button-disabled" tabindex="-1" aria-label="Next slide" aria-controls="swiper-wrapper-6197efd36115bc78" aria-disabled="true" disabled="">❯</button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <style>
          .products-carousel .swiper-slide {
            height: auto;
            display: flex;
          }
        </style>
        @if(count($topSelling) > 0)
        <div class="products-carousel swiper">
          <div class="swiper-wrapper">
            @foreach($topSelling as $product)
            <div class="swiper-slide">
              <div class="col">
                <div class="product-item h-100 d-flex flex-column">
                  <span class="badge bg-success position-absolute m-3"></span>
                  <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{encrypt($product->id)}}">
                    <svg width="14" height="14">
                      <use xlink:href="{{ $product->wishlists->isNotEmpty() ? '#trash' : '#heart' }}"></use>
                    </svg>
                  </button>
                  <figure>
                    <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" title="{{$product->name}}">
                      <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                    </a>
                  </figure>
                  <h3>{{$product->name}}</h3>
                  <span class="product-category">{{$product->type=='1'?'Sewa':'Produk'}} - {{$product->category->name}}</span>
                  <div class="position-absolute bottom-0 start-0 end-0 p-3">
                    <span class="price fw-bold fs-5 text-primary">Rp {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                    <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-outline-primary btn-sm mt-2 w-100 fw-semibold">Lihat</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @else
        <p class="text-center">Data tidak ditemukan</p>
        @endif
        <!-- / products-carousel -->

      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container-fluid">
    <h2 class="my-5">Pencarian Populer</h2>
    @foreach($popularKeywords as $v)
    <a href="{{ route('frontend.product.category', ['category' => 'all', 'q' => $v->keyword]) }}"
      class="btn btn-warning position-relative me-2 mb-2">
      {{ $v->keyword }}
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ $v->total }}
      </span>
    </a>
    @endforeach
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="mitra-carousel swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-1.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-2.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-3.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-4.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-5.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-6.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
        <div class="swiper-slide text-center">
          <img src="{{asset('frontend/images/mitra/clients-7.webp')}}"
            alt="Mitra" class="img-fluid mb-2">
        </div>
      </div>
    </div>
  </div>
</section>


@endsection

@section('script')
<script>
  $(document).ready(function() {})
</script>
@endsection
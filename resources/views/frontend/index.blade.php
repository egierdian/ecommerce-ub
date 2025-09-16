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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                      <a href="{{$slider->url}}" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 mb-4">Belanja Sekarang </a>
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

<section class="pb-5">
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
                    <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{($product->id)}}">
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

                    {{-- Rating --}}
                    <div class="rating my-1">
                      @php $rating = $product->rating ?? 4; @endphp
                      @for($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star text-warning"></i>
                        @endfor
                        <span class="small text-muted">({{$product->reviews_count ?? rand(5, 50)}})</span>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 p-3">
                      <span class="price">Rp. {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-primary btn-sm mt-2 rounded-3 w-100 fw-semibold">Lihat</a>
                    </div>
                  </div>
                </div>
                @endforeach

              </div>
              <div class="text-center mt-4">
                <a href="{{route('frontend.product.category', ['category' => 'all'])}}" class="btn btn-outline-primary px-4 py-2">
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
                    <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{($product->id)}}"><svg width="14" height="14">
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
                      <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-primary btn-sm mt-2 rounded-3 w-100 fw-semibold">Lihat</a>
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
                <a href="{{route('frontend.product.category', ['category' => $category->slug])}}" class="btn btn-outline-primary px-4 py-2">
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
<section class="pt-5 overflow-hidden">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="section-header d-flex flex-wrap justify-content-between">

          <h2 class="section-title">Produk Terlaris</h2>

          <div class="d-flex align-items-center">
            <a href="#" class="btn-link text-decoration-none"> </a>
            <div class="swiper-buttons">
              <button class="swiper-prev products-carousel-prev btn btn-primary" tabindex="0" aria-label="Previous slide" aria-controls="swiper-wrapper-6197efd36115bc78" aria-disabled="false">❮</button>
              <button class="swiper-next products-carousel-next btn btn-primary swiper-button-disabled" tabindex="-1" aria-label="Next slide" aria-controls="swiper-wrapper-6197efd36115bc78" aria-disabled="true" disabled="">❯</button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
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
            <div class="col mb-5">
              <div class="product-item h-100 d-flex flex-column">
                <span class="badge bg-success position-absolute m-3"></span>
                <button href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{($product->id)}}">
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
                  <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-primary btn-sm mt-2 rounded-3 w-100 fw-semibold">Lihat</a>
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
</section>

<!-- rent product -->
<section class="py-5 bg-light">
  <div class="container-fluid">
    <h2 class="mb-4">Produk Sewa</h2>

    {{-- Form Filter Tanggal & Jam --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
      <div class="card-body">
        <p class="m-0">📅 Periksa jadwal ketersediaan sebelum melakukan pemesanan.</p>
        <form class="row g-3 align-items-end" id="#filterForm">
          <div class="col-md-5">
            <label for="start_datetime" class="form-label fw-semibold small text-muted">Mulai</label>
            <input type="text" id="start_datetime" name="start_datetime"
              class="form-control rounded-3"
              placeholder="Pilih tanggal & jam mulai"
              value="{{ request('start_datetime') }}">
          </div>
          <div class="col-md-5">
            <label for="end_datetime" class="form-label fw-semibold small text-muted">Selesai</label>
            <input type="text" id="end_datetime" name="end_datetime"
              class="form-control rounded-3"
              placeholder="Pilih tanggal & jam selesai"
              value="{{ request('end_datetime') }}">
          </div>
          <div class="col-md-2 d-grid">
            <button type="button" class="btn btn-primary rounded-3 fw-semibold" id="buttonFilter">
              <i class="fa fa-search me-1"></i>
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- Grid Produk --}}
    <div id="rentProducts">
    </div>
  </div>
</section>


<section class="pb-5 pt-2">
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
  $(document).ready(function() {
    const baseUrl = window.location.origin + '/' + window.location.pathname.split('/')[1] + '/public';
    // const baseUrl = window.location.origin 
    $('#buttonFilter').on('click', function(e) {
      console.log(baseUrl)
      let start = $('#start_datetime').val();
      let end = $('#end_datetime').val();
      $.ajax({
        url: "{{ route('frontend.product.rental.search') }}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          start_datetime: start,
          end_datetime: end
        },
        beforeSend: function() {
          // tampilkan loading
          $('#rentProducts').html(`
            <div class="text-center w-100 py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p class="mt-2">Sedang memuat produk...</p>
            </div>
          `);
        },
        success: function(res) {
          let html = '';
          if (res.data.length > 0) {
            $.each(res.data, function(i, product) {
              console.log(product)
              html += `
                          <div class="col">
                            <div class="product-item h-100 d-flex flex-column">
                              <figure>
                                <a href="${baseUrl}/product/${product.category.slug}/${product.slug}?param=${res.param}" title="${product.name}">
                                  <img src="${baseUrl}/${product.first_image?.path ?? ''}" class="tab-image" width="100%">
                                </a>
                              </figure>
                              <h3>${product.name}</h3>
                              <span class="product-category">${product.type == 1 ? 'Sewa' : 'Produk'} - ${product.category.name}</span>
                              <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                <span class="price">Rp. ${Number(product.type == 1 ? product.base_price_per_hour : product.price).toLocaleString('id-ID')}</span>
                                <a href="${baseUrl}/product/${product.category.slug}/${product.slug}?param=${res.param}" class="btn btn-primary btn-sm mt-2 rounded-3 w-100 fw-semibold">Sewa</a>
                              </div>
                            </div>
                          </div>`;
            });
            html = `<div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">${html}</div`
          } else {
            html = `<p class="text-muted text-center">Tidak ada produk tersedia di jam tersebut.</p>`;
          }
          $('#rentProducts').html(html);
        },
        error: function(err) {
          console.error(err);
          alert("Terjadi kesalahan saat mencari produk.");
        }
      })
    });
  })
  let startPicker, endPicker;

  startPicker = flatpickr("#start_datetime", {
    enableTime: true,
    time_24hr: true,
    minuteIncrement: 60, // hanya jam bulat
    dateFormat: "Y-m-d H:i",
    minDate: "today", // tidak boleh backdate
    minTime: "08:00",
    maxTime: "16:00",
    disableMobile: true,
    onChange: function(selectedDates) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      if (selectedDates.length > 0) {
        const start = selectedDates[0];

        // atur minDate di endPicker sesuai start
        endPicker.set("minDate", start);

        // kalau end sudah ada, tapi tidak valid, clear
        const endDate = endPicker.selectedDates[0];
        if (endDate) {
          if (
            start.toDateString() === endDate.toDateString() &&
            endDate.getHours() <= start.getHours()
          ) {
            endPicker.clear();
          }
        }
      }
    }
  });

  endPicker = flatpickr("#end_datetime", {
    enableTime: true,
    time_24hr: true,
    minuteIncrement: 60,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
    minTime: "08:00",
    maxTime: "17:00",
    disableMobile: true,
    onOpen: function(selectedDates, dateStr, instance) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      const start = startPicker.selectedDates[0];
      if (start) {
        // kalau tanggal end == start → jam akhir harus > jam awal
        instance.set("minDate", start);

        if (instance.selectedDates.length > 0 &&
          instance.selectedDates[0].toDateString() === start.toDateString()) {
          instance.set("minTime", (start.getHours() + 1).toString().padStart(2, '0') + ":00");
        } else {
          instance.set("minTime", "08:00");
        }
      }
    },
    onChange: function(selectedDates, dateStr, instance) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      const start = startPicker.selectedDates[0];
      if (start && selectedDates.length > 0) {
        const end = selectedDates[0];

        if (start.toDateString() === end.toDateString()) {
          instance.set("minTime", (start.getHours() + 1).toString().padStart(2, '0') + ":00");
        } else {
          instance.set("minTime", "08:00");
        }
      }
    }
  });
</script>
@endsection
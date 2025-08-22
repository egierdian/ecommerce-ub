@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
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
            <a href="#" class="nav-link category-item swiper-slide">
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
            <h3>Produk terlaris</h3>
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
                  <div class="product-item">
                    <!-- <span class="badge bg-success position-absolute m-3">-30%</span> -->
                    <a href="#" class="btn-wishlist"><svg width="24" height="24">
                        <use xlink:href="#heart"></use>
                      </svg></a>
                    <figure>
                      <a href="#" title="{{$product->name}}">
                        <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$product->name}}</h3>
                    <span class="price">Rp. {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                    <a href="">Lihat</a>
                  </div>
                </div>
                @endforeach

              </div>
              <!-- / product-grid -->

            </div>

            @foreach($categories as $category)
            <div class="tab-pane fade" id="{{$category->slug}}" role="tabpanel" aria-labelledby="{{$category->slug}}-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @foreach($category->products as $product)
                <div class="col">
                  <div class="product-item">
                    <!-- <span class="badge bg-success position-absolute m-3">-30%</span> -->
                    <a href="#" class="btn-wishlist"><svg width="24" height="24">
                        <use xlink:href="#heart"></use>
                      </svg></a>
                    <figure>
                      <a href="#" title="{{$product->name}}">
                        <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$product->name}}</h3>
                    <span class="price">Rp. {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                    <a href="">Lihat</a>
                  </div>
                </div>
                @endforeach
              </div>
              <!-- / product-grid -->

            </div>
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

      <div class="col-md-6">
        <div class="banner-ad bg-danger mb-3" style="background: url('images/ad-image-3.png');background-repeat: no-repeat;background-position: right bottom;">
          <div class="banner-content p-5">

            <div class="categories text-primary fs-3 fw-bold">Upto 25% Off</div>
            <h3 class="banner-title">Luxa Dark Chocolate</h3>
            <p>Very tasty & creamy vanilla flavour creamy muffins.</p>
            <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

          </div>

        </div>
      </div>
      <div class="col-md-6">
        <div class="banner-ad bg-info" style="background: url('images/ad-image-4.png');background-repeat: no-repeat;background-position: right bottom;">
          <div class="banner-content p-5">

            <div class="categories text-primary fs-3 fw-bold">Upto 25% Off</div>
            <h3 class="banner-title">Creamy Muffins</h3>
            <p>Very tasty & creamy vanilla flavour creamy muffins.</p>
            <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<section id="latest-blog" class="py-5">
  <div class="container-fluid">
    <div class="row">
      <div class="section-header d-flex align-items-center justify-content-between my-5">
        <h2 class="section-title">Our Recent Blog</h2>
        <div class="btn-wrap align-right">
          <a href="#" class="d-flex align-items-center nav-link">Read All Articles <svg width="24" height="24">
              <use xlink:href="#arrow-right"></use>
            </svg></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <article class="post-item card border-0 shadow-sm p-3">
          <div class="image-holder zoom-effect">
            <a href="#">
              <img src="images/post-thumb-1.jpg" alt="post" class="card-img-top">
            </a>
          </div>
          <div class="card-body">
            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
              <div class="meta-date"><svg width="16" height="16">
                  <use xlink:href="#calendar"></use>
                </svg>22 Aug 2021</div>
              <div class="meta-categories"><svg width="16" height="16">
                  <use xlink:href="#category"></use>
                </svg>tips & tricks</div>
            </div>
            <div class="post-header">
              <h3 class="post-title">
                <a href="#" class="text-decoration-none">Top 10 casual look ideas to dress up your kids</a>
              </h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
            </div>
          </div>
        </article>
      </div>
      <div class="col-md-4">
        <article class="post-item card border-0 shadow-sm p-3">
          <div class="image-holder zoom-effect">
            <a href="#">
              <img src="images/post-thumb-2.jpg" alt="post" class="card-img-top">
            </a>
          </div>
          <div class="card-body">
            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
              <div class="meta-date"><svg width="16" height="16">
                  <use xlink:href="#calendar"></use>
                </svg>25 Aug 2021</div>
              <div class="meta-categories"><svg width="16" height="16">
                  <use xlink:href="#category"></use>
                </svg>trending</div>
            </div>
            <div class="post-header">
              <h3 class="post-title">
                <a href="#" class="text-decoration-none">Latest trends of wearing street wears supremely</a>
              </h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
            </div>
          </div>
        </article>
      </div>
      <div class="col-md-4">
        <article class="post-item card border-0 shadow-sm p-3">
          <div class="image-holder zoom-effect">
            <a href="#">
              <img src="images/post-thumb-3.jpg" alt="post" class="card-img-top">
            </a>
          </div>
          <div class="card-body">
            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
              <div class="meta-date"><svg width="16" height="16">
                  <use xlink:href="#calendar"></use>
                </svg>28 Aug 2021</div>
              <div class="meta-categories"><svg width="16" height="16">
                  <use xlink:href="#category"></use>
                </svg>inspiration</div>
            </div>
            <div class="post-header">
              <h3 class="post-title">
                <a href="#" class="text-decoration-none">10 Different Types of comfortable clothes ideas for women</a>
              </h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container-fluid">
    <h2 class="my-5">People are also looking for</h2>
    <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
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
@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
  .product-item {
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

  .product-item .thumb-img {
    cursor: pointer;
    max-height: 100px;
    object-fit: cover;
    border: 2px solid transparent;
    border: 1px solid rgba(0, 0, 0, 0.5);
  }
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5); /* biar ada kontras */
    border-radius: 50%;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.6); /* shadow biar jelas */
    background-size: 60% 60%; /* kecilin icon biar pas */
  }
</style>
<section class="py-5">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="card product-item">
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
                <div class="row mt-3">
                  <div class="d-flex overflow-auto gap-2 p-1">
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
                <p class="text-muted">{{$product->category->name}}</p>
                <h4 class="price">Rp {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</h4>
                {!! $product->description !!}
                <div>
                  <button class="btn btn-primary">Pesan</button>
                </div>
              </div>
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
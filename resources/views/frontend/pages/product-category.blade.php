@extends('frontend.layouts.master')

@if($search)
  @section('title', 'Hasil pencarian ' . $search)
@else
  @section('title', $dataCategory->name ?? 'Kategori')
@endif

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')

<section class="py-3">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">

        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header justify-content-between border-bottom mb-2 text-center">

            @if($search)
            <p>
              Hasil pencarian <b>'{{ $search }}'</b>
            </p>
            @else
            <h3>
              {{ $dataCategory->name ?? '' }}
            </h3>
            @endif
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @if(count($products) > 0)
                @foreach($products as $product)
                <div class="col">
                  <div class="product-item">
                    <!-- <span class="badge bg-success position-absolute m-3">-30%</span> -->
                    <a href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{encrypt($product->id)}}">
                      <svg width="24" height="24">
                        <use xlink:href="{{ $product->wishlists->isNotEmpty() ? '#trash' : '#heart' }}"></use>
                      </svg>
                    </a>
                    <figure>
                      <a href="#" title="{{$product->name}}">
                        <img src="{{asset($product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$product->name}}</h3>
                    <span class="price">Rp. {{number_format(($product->type == 1 ? $product->base_price_per_hour : $product->price), 0, ',', '.')}}</span>
                    <a href="{{route('frontend.product.category', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="btn btn-dark rounded-2 mt-2">Detail</a>
                  </div>
                </div>
                @endforeach
                @else
                <div class="col text-center w-100 mb-4">
                  Data tidak ditemukan.
                </div>
                @endif
              </div>
              <!-- / product-grid -->

            </div>
          </div>
          <div class="mt-4">
            {{ $products->links('frontend.layouts.pagination') }}
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
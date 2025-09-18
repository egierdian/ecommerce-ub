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

<section class="py-5">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">

        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header justify-content-between mb-4 text-center">

            @if($search)
            <p>
              Hasil pencarian <b>'{{ $search }}'</b>
            </p>
            @else
            <h3>
              @if(isset($dataCategory->name))
              Kategori {{ $dataCategory->name ?? '' }}
              @else 
              Semua Produk
              @endif
            </h3>
            @endif
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @if(count($products) > 0)
                @foreach($products as $product)
                <div class="col">
                  <div class="product-item h-100 d-flex flex-column">
                    <span class="badge bg-success position-absolute m-3"></span>
                    <a href="#" class="btn-wishlist {{ $product->wishlists->isNotEmpty() ? 'active' : '' }}" data-id="{{encrypt($product->id)}}">
                      <svg width="14" height="14">
                        <use xlink:href="{{ $product->wishlists->isNotEmpty() ? '#trash' : '#heart' }}"></use>
                      </svg>
                    </a>
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
  })
</script>
@endsection
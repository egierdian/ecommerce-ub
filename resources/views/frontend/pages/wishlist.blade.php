@extends('frontend.layouts.master')

@section('title', 'Wishlist')

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
          
            <h3>
              Wishlist
            </h3>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @if(count($wishlists) > 0)
                @foreach($wishlists as $wishlist)
                <div class="col">
                  <div class="product-item">
                    <figure>
                      <a href="#" title="{{$wishlist->product->name}}">
                        <img src="{{asset($wishlist->product->firstImage->path ?? '')}}" class="tab-image" width="100%">
                      </a>
                    </figure>
                    <h3>{{$wishlist->product->name}}</h3>
                    <span class="price">Rp. {{number_format(($wishlist->product->type == 1 ? $wishlist->product->base_price_per_hour : $wishlist->product->price), 0, ',', '.')}}</span>
                    <a href="{{route('frontend.product.category', ['category' => $wishlist->product->category->slug, 'product' => $wishlist->product->slug])}}" class="btn btn-dark rounded-2 mt-2">Detail</a>
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
            {{ $wishlists->links('frontend.layouts.pagination') }}
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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @hasSection('title')
            @yield('title') - {{ $webSettings['title_website'] ?? 'UBakrie' }}
        @else
            {{ $webSettings['title_website'] ?? 'UBakrie' }}
        @endif
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"> -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/style.css')}}">
    <link rel="icon" href="{{asset($webSettings['x_icon']??'')}}" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	<script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("assets/css/fonts.min.css")}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

    <style>
        
        .goog-te-banner-frame.skiptranslate {
            margin-top: 0 !important;
            height: 40px !important; /* tetap hitung tinggi biar observer detect */
            visibility: visible !important;
        }
        .change-language {
            padding: 10px; 
            border: 1px solid #f2f2f2;
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
    @yield('style')
</head>

<body>

    @php
        $totalPrice = $carts->sum(function($cart) {
            return $cart->subtotal;
        });
        $totalPriceText = number_format($totalPrice, 0, ',', '.');
    @endphp
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                <path fill="currentColor" d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                <path fill="currentColor" d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
        </defs>
    </svg>

    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Keranjang</span>
                    <span class="badge bg-primary rounded-pill count-cart">{{count($carts)}} Item</span>
                </h4>
                <ul class="list-group mb-3">
                    <div class="section-message"></div>
                    @foreach($carts as $cart)
                    <li class="list-group-item d-flex justify-content-between lh-sm align-items-center" id="cart-item-{{($cart->id)}}">
                        <div style="width:65%;">
                            <h6 class="my-0">{{$cart->product->name}}</h6>
                            @if($cart->product->type != 1)
                            <div class="section-add-cart" style="margin: 0px; padding: 0px; border: none;">
                                <div class="d-flex align-items-center gap-3">
                                <div class="input-group product-qty item-quantity-cart-{{$cart->id}}">
                                    <span class="input-group-btn">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                        <svg width="16" height="16">
                                        <use xlink:href="#minus"></use>
                                        </svg>
                                    </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantityCart" class="form-control input-number" value="{{$cart->qty}}">
                                    <span class="input-group-btn">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                        <svg width="16" height="16">
                                        <use xlink:href="#plus"></use>
                                        </svg>
                                    </button>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3 btn-update-cart" data-id="{{$cart->id}}">
                                    Perbarui
                                </button>
                                </div>
                            </div>
                            @else
                            <div>
                                <span class="m-0">Jumlah 1</span>
                            </div>
                            @endif
                        </div>
                        <div style="text-align: right;width: 35%;">
                            <p class="text-body-secondary m-0">Rp {{number_format($cart->price, 0, ',', '.')}}</p>
                            <button class="btn btn-sm btn-delete-cart" style="padding: 0 7px;" data-id="{{$cart->id}}"><i class="fa fa-trash"></i></button>
                        </div>
                    </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong class="cart-total">Rp {{$totalPriceText}}</strong>
                    </li>
                </ul>

                <form action="{{route('frontend.checkout')}}" method="GET" class="flex items-center gap-2">
                  @csrf
                <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch" aria-labelledby="Search">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Search</span>
                </h4>
                <form role="search" action="{{route('frontend.product.category', ['category' => 'all'])}}" method="get" class="d-flex mt-3 gap-0">
                    <input class="form-control rounded-start rounded-0 bg-light" type="text" name="q" placeholder="What are you looking for?" aria-label="What are you looking for?" autocomplete="off">
                    <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div id="google_translate_element" style="display:none;"></div>
    <header id="headerSection">
        <div class="container-fluid">
            <div class="row py-3 border-bottom">

                <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                    <div class="main-logo">
                        <a href="{{route('frontend.index')}}">
                            <img src="{{asset($webSettings['logo_website'] ?? '')}}" alt="logo" height="70">
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-4 d-none d-lg-block">
                    <div class="search-bar row bg-light p-2 my-2 rounded-4">
                        <!-- <div class="col-md-4 d-none d-md-block">
                            <select class="form-select border-0 bg-transparent">
                                <option>All Categories</option>
                                @foreach($menuCategories as $category) 
                                <option name="{{$category->slug}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div> -->
                        <div class="col-11 col-md-11">
                            <form id="search-form" class="text-center" action="{{route('frontend.product.category', ['category' => 'all'])}}" method="get">
                                <input type="text" name="q" class="form-control border-0 bg-transparent" placeholder="Search for more than 1,000 products" autocomplete="off" />
                            </form>
                        </div>
                        <div class="col-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8 col-lg-5 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                    <div class="support-box text-end">
                        <!-- <span class="fs-6 text-muted">Butuh Bantuan?</span>
                        <h5 class="mb-0">{{$webSettings['contact_phone']??''}}</h5> -->
                        <div class="d-flex gap-3 change-language">
                            <img src="https://flagcdn.com/w40/id.png" class="flag-icon" onclick="translatePage('id')" title="Bahasa Indonesia" width="30">
                            <img src="https://flagcdn.com/w40/gb.png" class="flag-icon" onclick="translatePage('en')" title="English" width="30">
                        </div>
                    </div>

                    <ul class="d-flex justify-content-end list-unstyled m-0">
                        @if(Auth::check())
                        <li>
                            <a href="{{Auth::user()->role == 'customer' ? route('frontend.dashboard') : route('admin.dashboard')}}" class="rounded-circle bg-light p-2 mx-1">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg>
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="{{route('login')}}" class="rounded-circle bg-light p-2 mx-1">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg>
                            </a>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="{{route('frontend.wishlist')}}" class="rounded-circle bg-light p-2 mx-1">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg>
                            </a>
                        </li> -->
                        <li class="d-lg-none">
                            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="d-lg-none">
                            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#search"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>

                    <div class="cart text-end d-none d-lg-block dropdown">
                        <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <span class="fs-6 text-muted dropdown-toggle">Keranjang</span>
                            <span class="cart-total fw-bold">Rp {{$totalPriceText}}</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- content section -->
    @yield('content')
    <!-- end content section -->

    <footer class="py-5">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-menu">
                        <img src="{{asset($webSettings['logo_footer']??'')}}" alt="logo" height="60">
                        <div class="social-links mt-5">
                            <ul class="d-flex list-unstyled gap-2">
                                <!-- <li>
                                    <a href="{{$webSettings['facebook']??''}}" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z" />
                                        </svg>
                                    </a>
                                </li> -->
                                <li>
                                    <a href="{{$webSettings['instagram']??''}}" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $webSettings['linkedin'] ?? '' }}" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 448 512" fill="currentColor">
                                        <path d="M100.28 448H7.4V148.9h92.88zM53.79 
                                                108.1C24.09 108.1 0 83.5 0 
                                                53.8a53.8 53.8 0 1 1 107.6 0c0 
                                                29.7-24.1 54.3-53.81 54.3zM447.9 
                                                448h-92.4V306.4c0-33.7-.7-77-46.9-77-46.9 
                                                0-54.1 36.6-54.1 74.4V448h-92.4V148.9h88.7v40.8h1.3c12.4-23.5 
                                                42.6-48.4 87.7-48.4 93.7 0 111.1 
                                                61.6 111.1 141.7V448z"/>
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{$webSettings['youtube']??''}}" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $webSettings['tiktok'] ?? '' }}" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 448 512" fill="currentColor">
                                        <path d="M448,209.91c-17.55,0-34.48-2.06-50.86-5.93V358.4
                                                c0,84.18-68.28,152.46-152.46,152.46S92.22,442.58,92.22,358.4
                                                c0-71.28,48.94-131.28,115.46-148.17v79.94
                                                c-22.26,10.14-37.72,32.61-37.72,58.23
                                                c0,35.67,28.91,64.58,64.58,64.58s64.58-28.91,64.58-64.58V0h84.18
                                                c0,69.28,56.12,125.46,125.46,125.46V209.91z"/>
                                        </svg>
                                    </a>
                                </li>

                                <li hidden>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M1.04 17.52q.1-.16.32-.02a21.308 21.308 0 0 0 10.88 2.9a21.524 21.524 0 0 0 7.74-1.46q.1-.04.29-.12t.27-.12a.356.356 0 0 1 .47.12q.17.24-.11.44q-.36.26-.92.6a14.99 14.99 0 0 1-3.84 1.58A16.175 16.175 0 0 1 12 22a16.017 16.017 0 0 1-5.9-1.09a16.246 16.246 0 0 1-4.98-3.07a.273.273 0 0 1-.12-.2a.215.215 0 0 1 .04-.12Zm6.02-5.7a4.036 4.036 0 0 1 .68-2.36A4.197 4.197 0 0 1 9.6 7.98a10.063 10.063 0 0 1 2.66-.66q.54-.06 1.76-.16v-.34a3.562 3.562 0 0 0-.28-1.72a1.5 1.5 0 0 0-1.32-.6h-.16a2.189 2.189 0 0 0-1.14.42a1.64 1.64 0 0 0-.62 1a.508.508 0 0 1-.4.46L7.8 6.1q-.34-.08-.34-.36a.587.587 0 0 1 .02-.14a3.834 3.834 0 0 1 1.67-2.64A6.268 6.268 0 0 1 12.26 2h.5a5.054 5.054 0 0 1 3.56 1.18a3.81 3.81 0 0 1 .37.43a3.875 3.875 0 0 1 .27.41a2.098 2.098 0 0 1 .18.52q.08.34.12.47a2.856 2.856 0 0 1 .06.56q.02.43.02.51v4.84a2.868 2.868 0 0 0 .15.95a2.475 2.475 0 0 0 .29.62q.14.19.46.61a.599.599 0 0 1 .12.32a.346.346 0 0 1-.16.28q-1.66 1.44-1.8 1.56a.557.557 0 0 1-.58.04q-.28-.24-.49-.46t-.3-.32a4.466 4.466 0 0 1-.29-.39q-.2-.29-.28-.39a4.91 4.91 0 0 1-2.2 1.52a6.038 6.038 0 0 1-1.68.2a3.505 3.505 0 0 1-2.53-.95a3.553 3.553 0 0 1-.99-2.69Zm3.44-.4a1.895 1.895 0 0 0 .39 1.25a1.294 1.294 0 0 0 1.05.47a1.022 1.022 0 0 0 .17-.02a1.022 1.022 0 0 1 .15-.02a2.033 2.033 0 0 0 1.3-1.08a3.13 3.13 0 0 0 .33-.83a3.8 3.8 0 0 0 .12-.73q.01-.28.01-.92v-.5a7.287 7.287 0 0 0-1.76.16a2.144 2.144 0 0 0-1.76 2.22Zm8.4 6.44a.626.626 0 0 1 .12-.16a3.14 3.14 0 0 1 .96-.46a6.52 6.52 0 0 1 1.48-.22a1.195 1.195 0 0 1 .38.02q.9.08 1.08.3a.655.655 0 0 1 .08.36v.14a4.56 4.56 0 0 1-.38 1.65a3.84 3.84 0 0 1-1.06 1.53a.302.302 0 0 1-.18.08a.177.177 0 0 1-.08-.02q-.12-.06-.06-.22a7.632 7.632 0 0 0 .74-2.42a.513.513 0 0 0-.08-.32q-.2-.24-1.12-.24q-.34 0-.8.04q-.5.06-.92.12a.232.232 0 0 1-.16-.04a.065.065 0 0 1-.02-.08a.153.153 0 0 1 .02-.06Z" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Informasi</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="{{route('frontend.about-us')}}" class="nav-link">Tentang Kami</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('frontend.product.rental')}}" class="nav-link">Produk Sewa</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Akun</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="{{route('login')}}" class="nav-link">Masuk</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('register')}}" class="nav-link">Daftar</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Layanan Pelanggan</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="{{route('frontend.faq')}}" class="nav-link">FAQ</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('frontend.contact')}}" class="nav-link">Kontak</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6" hidden>
                    <div class="footer-menu">
                        <h5 class="widget-title">Berlangganan</h5>
                        <p>Daftar untuk menerima berita terbaru dan penawaran menarik dari kami.</p>
                        <form class="d-flex mt-3 gap-0" role="newsletter">
                            <input class="form-control rounded-start rounded-0 bg-light" 
                                type="email" 
                                placeholder="Alamat Email" 
                                aria-label="Alamat Email">
                            <button class="btn btn-dark rounded-end rounded-0" type="button">Daftar</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <div id="footer-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>© {{date('Y')}} {{$webSettings['title_website']??''}}. All rights reserved.</p>
                </div>
                <div class="col-md-6 credit-link text-start text-md-end">
                </div>
            </div>
        </div>
    </div>
    
    <div class="floating-contact" id="floatingContact">
        <button class="contact-main" id="contactMain"><i class="fa fa-envelope"></i></button>
        <!-- <a href="https://wa.me/" target="_blank" 
        class="contact-item" title="WhatsApp 1">
            <i class="fab fa-whatsapp"></i>
        </a> -->

        <a href="https://wa.me/{{ preg_replace('/\D/', '', $webSettings['contact_whatsapp'] ?? '') }}" target="_blank" 
        class="contact-item" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

        <a href="mailto:{{$webSettings['contact_email']??''}}" 
        class="contact-item" title="Email">
            <i class="fa fa-envelope"></i>
        </a>
    </div>
    <script src="{{asset('frontend/js/jquery-1.11.0.min.js')}}"></script>
    <!-- <script src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}" ></script>
    <script src="{{asset('frontend/js/plugins.js')}}"></script>
    <script src="{{asset('frontend/js/script.js')}}?v={{ filemtime(public_path('frontend/js/script.js')) }}"></script>
    <script src="{{asset('frontend/js/global.js')}}?v={{ filemtime(public_path('frontend/js/global.js')) }}"></script>

    <script>
    (function(){
        const contact = document.getElementById('floatingContact');
        const mainBtn = document.getElementById('contactMain');

        // deteksi device touch dengan beberapa indikator
        function isTouchDevice(){
            return (('ontouchstart' in window) || navigator.maxTouchPoints > 0 || window.matchMedia('(pointer: coarse)').matches);
        }

        // helper toggle / close
        function toggleMenu(e){
            if (e && e.stopPropagation) e.stopPropagation();
            contact.classList.toggle('active');
        }
        function closeMenu(){
            contact.classList.remove('active');
        }

        // Untuk menghindari double-toggle ketika device memicu touch + click
        let lastTouchTime = 0;

        // HANDLER untuk tombol utama
        function onMainTouchStart(e){
            // pencegahan default supaya browser tidak memicu click ganda
            if (e && e.preventDefault) e.preventDefault();
            lastTouchTime = Date.now();
            toggleMenu(e);
        }
        function onMainClick(e){
            // jika klik terjadi segera setelah touch (<= 600ms), abaikan click
            if (Date.now() - lastTouchTime < 600) return;
            // hanya toggle via click pada perangkat touch (jika ingin mencegah toggling di desktop,
            // ubah kondisi ini). Kita toggle hanya bila device touch.
            if (isTouchDevice()) {
            toggleMenu(e);
            }
        }

        // daftar event sesuai device
        if (isTouchDevice()) {
            // touch devices -> pakai touchstart & click (dengan guard)
            mainBtn.addEventListener('touchstart', onMainTouchStart, {passive:false});
            mainBtn.addEventListener('click', onMainClick);

            // klik / tap di luar -> tutup
            document.addEventListener('touchstart', function(e){
            if (!contact.contains(e.target)) closeMenu();
            });
            document.addEventListener('click', function(e){
            if (!contact.contains(e.target)) closeMenu();
            });

        } else {
            // non-touch (desktop) -> biarkan hover CSS yang mengendalikan
            // optional: jika user klik mainBtn di desktop, kita tidak toggle. (keputusan desain)
            // Namun kita tetap stopPropagation agar klik di mainBtn tidak men-trigger document listener jika ada.
            mainBtn.addEventListener('click', function(e){
            e.stopPropagation();
            });
            // pastikan klik di luar menutup jika .active tetap terpasang (misal akibat js sebelumnya)
            document.addEventListener('click', function(e){
            if (!contact.contains(e.target)) closeMenu();
            });
        }

        // keyboard: Escape untuk tutup
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape') closeMenu();
        });

        // resize/orientation change -> reset pada mode non-touch
        window.addEventListener('resize', function(){
            if (!isTouchDevice()) closeMenu();
        });
    })();
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
        new google.translate.TranslateElement(
            { pageLanguage: 'id', includedLanguages: 'id,en' },
            'google_translate_element'
        );
        }

        function translatePage(lang) {
        var selectField = document.querySelector("select.goog-te-combo");
        if (selectField) {
            selectField.value = lang;
            selectField.dispatchEvent(new Event("change"));
            document.getElementById("headerSection").style.paddingTop = "40px"; // tambah padding ketika aktif
        }
        }

        // Deteksi jika user menutup translate bar
        const observer = new MutationObserver(() => {
        let iframe = document.querySelector(".goog-te-banner-frame");
        if (!iframe) {
            document.getElementById("headerSection").style.paddingTop = "0px"; // hapus padding ketika translate hilang
        }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    @yield('script')
</body>

</html>
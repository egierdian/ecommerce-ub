@extends('frontend.layouts.master')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

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

    .sidebar {
        min-height: 80vh;
        background: #212529;
        color: #fff;
    }

    .sidebar .nav-link {
        color: #adb5bd;
        border-radius: .5rem;
        margin: 5px 10px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        color: #fff;
        background-color: #495057;
    }

    .sidebar h4 {
        font-size: 1.2rem;
        padding: 0 15px;
        margin-bottom: 1rem;
    }

    .card-custom {
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('content')

<section class="py-3">
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar for desktop -->
            <nav class="col-md-4 col-lg-3 d-none d-md-block sidebar p-3">
                <div class="d-flex flex-column h-100">
                    <h4 class="px-2 text-white mb-3">👤 Pembeli</h4>
                    <ul class="nav flex-column mb-auto">
                        <li>
                            <a href="{{route('frontend.dashboard')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.my-order')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.my-order') ? 'active' : '' }}">
                                <i class="fas fa-shopping-basket me-2"></i> Pesanan Saya
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.product-paid')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.product-paid') ? 'active' : '' }}">
                                <i class="fas fa-box-open me-2"></i> Produk Terbeli
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.review')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.review') ? 'active' : '' }}">
                                <i class="fas fa-star me-2"></i> Penilaian
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.wishlist')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.wishlist') ? 'active' : '' }}">
                                <i class="fas fa-heart me-2"></i> Wishlist
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.change-password')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.change-password') ? 'active' : '' }}">
                                <i class="fas fa-key me-2"></i> Password
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.profile')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.profile') ? 'active' : '' }}">
                                <i class="fas fa-user me-2"></i> Profil
                            </a>
                        </li>

                    </ul>
                    <div class="px-2 mt-auto">
                        <a href="{{route('logout')}}" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                    </div>
                </div>
            </nav>

            <!-- Offcanvas Sidebar for mobile -->
            <div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="offcanvasSidebar">
                <div class="offcanvas-header">
                    <h4 class="text-white mb-0">👤 Pembeli</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column">
                    <ul class="nav flex-column mb-auto">
                        <li>
                            <a href="{{route('frontend.dashboard')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.my-order')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.my-order') ? 'active' : '' }}">
                                <i class="fas fa-shopping-basket me-2"></i> Pesanan Saya
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.product-paid')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.product-paid') ? 'active' : '' }}">
                                <i class="fas fa-box-open me-2"></i> Produk Terbeli
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.review')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.review') ? 'active' : '' }}">
                                <i class="fas fa-star me-2"></i> Penilaian
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.wishlist')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.wishlist') ? 'active' : '' }}">
                                <i class="fas fa-heart me-2"></i> Wishlist
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.change-password')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.change-password') ? 'active' : '' }}">
                                <i class="fas fa-key me-2"></i> Password
                            </a>
                        </li>

                        <li>
                            <a href="{{route('frontend.dashboard.profile')}}"
                                class="nav-link {{ request()->routeIs('frontend.dashboard.profile') ? 'active' : '' }}">
                                <i class="fas fa-user me-2"></i> Profil
                            </a>
                        </li>
                    </ul>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="col-md-8 ms-sm-auto col-lg-9 px-md-4 py-3">
                <!-- Mobile topbar with menu button -->
                <div class="d-md-none mb-3">
                    <button class="btn btn-dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                        <i class="fa fa-bars"></i> Menu
                    </button>
                </div>

                @yield('dashboard-content')
            </main>
        </div>
    </div>
</section>
@endsection

@section('script')
<!-- DataTables -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".datatableCustomer").DataTable({
            order: [
                [1, "desc"]
            ]
        });

        
        $('.btn-review').click(function(){
            let productId = $(this).data('product-id');
            let productName = $(this).data('product-name');

            $('#reviewModalLabel').text('Beri Penilaian untuk ' + productName);
            $('#product_id').val(productId);

            $('#reviewModal').modal('show');
        });
    })

    function showModalUpload(e) {
        let data = $(e).data()

        $("#modalUpload").modal("show")
        $("#modalUpload [name=id]").val(data.id)
    }
</script>
@endsection
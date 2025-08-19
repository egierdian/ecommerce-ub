@extends('layouts.master')
@section('content')
<div class="panel-header bg-info-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                <h5 class="text-white op-7 mb-2">Selamat datang</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-white btn-border btn-round px-4"><i class="fas fa-plus"></i> Device</a>
                <a href="#" class="btn btn-secondary btn-round px-4"><i class="fas fa-plus"></i> Broadcast</a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="card-title">Ringkasan</div>
                            <div class="card-category">Berikut detail ringkasan akun anda</div>
                        </div>
                        <div class="col-md-5 text-right">
                            <div class="card-tools">
                                <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
                                    <i class="icon-arrow-up-circle"></i> Perpanjang Paket
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-1"></div>
                            <h6 class="fw-bold mt-3 mb-0">Device</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-2"></div>
                            <h6 class="fw-bold mt-3 mb-0">Kontak</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-3"></div>
                            <h6 class="fw-bold mt-3 mb-0">Masa Aktif (hari)</h6>
                        </div>
                    </div>
                    <h5 class="mt-2">Paket anda telah expired, silahkan perpanjang </h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-time"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Pesan Pending</p>
                                        <h4 class="card-title"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-message"></i>
                                    </div>
                                </div>
                                <div class="col-8 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Pesan Terkirim Hari Ini</p>
                                        <h4 class="card-title"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-time"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Broadcast Pending</p>
                                        <h4 class="card-title"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-message"></i>
                                    </div>
                                </div>
                                <div class="col-8 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Broadcast Terkirim Hari ini</p>
                                        <h4 class="card-title"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
			<div class="card">
				<div class="card-body">
				    <div class="chart-container">
					    <canvas id="barChartMessageStatus"></canvas>
					</div>
				</div>
			</div>
        </div>
        <div class="col-md-6">
			<div class="card">
				<div class="card-body">
				    <div class="chart-container">
					    <canvas id="barChartBroadcastStatus"></canvas>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="modal" role="dialog" id="welcomeModal" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('assets/img/whatsa_wa.png')}}" width="300" preloader alt="">
                <h2 class="mb-2">Halo, Selamat datang di Watsha.id</h2>
                <h5>Langkah pertama silahkan menambahkan device anda</h5>
                <div class="mt-5">
                    <a href="#" class="btn btn-primary">Tambah Sekarang</a>
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal" id="btnNanti">Nanti</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    console.log('tst')
</script>
@endsection
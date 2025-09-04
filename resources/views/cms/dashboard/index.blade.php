@extends('cms.layouts.master')

@section('content')
<div class="page-inner">
    <h4 class="page-title">E-Commerce Dashboard</h4>
    <div class="row">
        <!-- KPI Cards -->
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Orders</p>
                                <h4 class="card-title">{{number_format($total_order, 0, ',', '.')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Revenue</p>
                                <h4 class="card-title">Rp {{number_format($total_revenue, 0, ',', '.')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Customers</p>
                                <h4 class="card-title">{{number_format($total_customer, 0, ',', '.')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Recent Orders -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Orders</div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->code}}</td>
                                <td>{{$transaction->user->name}} ({{$transaction->user->email}})</td>
                                <td>Rp {{number_format($transaction->total, 0, ',', '.')}}</td>
                                <td>{!! paymentStatusBadge($transaction->status)!!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Top Products</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($top_products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$product->product_name}} <span class="badge badge-primary">{{number_format($product->sold, 0, ',', '.')}} sold</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection

@extends('admin.layout.base')
@section('title', 'Dashboard')
@section('data-page-id', 'adminDashboard')

@section('content')
    <div class="dashboard admin_shared">
        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4" data-equalizer data-equalizer-on="medium" style="padding-left: 1rem;">
            {{--Order summary--}}
            <div class="small-12 medium-6 large-3 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Total orders</p><h4>{{ $orders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="row column">
                            <a href="#">Order details</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Stock summary--}}
            <div class="small-12 medium-6 large-3 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Stock</p><h4>{{ $products }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="row column">
                            <a href="{{ getenv('APP_URL') }}/admin/products">View products</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Revenue summary--}}
            <div class="small-12 medium-6 large-3 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Revenue</p><h4>${{ number_format($payments, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="row column">
                            <a href="#">Payment details</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Signup summary--}}
            <div class="small-12 medium-6 large-3 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Signup</p><h4>{{ $users }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="row column">
                            <a href="{{ getenv('APP_URL') }}/admin/users">Registered users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-2 graph">
            <div class="small-12 medium-6 column monthly-sales">
                <div class="card">
                    <div class="card-section">
                        <h4>Monthly orders</h4>
                        <canvas id="order"></canvas>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 column monthly-revenue">
                <div class="card">
                    <div class="card-section">
                        <h4>Monthly revenue</h4>
                        <canvas id="revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
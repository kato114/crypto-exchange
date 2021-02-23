@extends('admin')

@section('body')

    @php
        $totalusers = \App\User::count();
       $banusers = \App\User::where('status',0)->count();
       $verifiedPhone = \App\User::where('phone_verify',1)->count();
       $verifiedEmail = \App\User::where('email_verify',1)->count();
       $activeusers = \App\User::where('status',1)->count();

        $gateway =  App\Gateway::count();
        $deposit =  App\Deposit::whereStatus(1)->count();
        $totalDeposit =  App\Deposit::whereStatus(1)->sum('amount');

        $blog =App\Post::count();
        $subscribers =App\Subscriber::count();

    $currency =  App\Currency::count();
    $buycurrency =  App\BuyMoney::where('status','!=',0)->count();
    $sellcurrency =  App\SellMoney::where('status','!=',0)->count();
    $exchangecurrency =  App\ExchangeMoney::where('status','!=',0)->count();

    @endphp

    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        </ul>
    </div>



    <div class="tile ">
        <h3 class="tile-title"><i class="fa fa-exchange"></i> Currency Statistics</h3>
        <div class="tile-body">
            <div class="row">

                <div class="col-lg-3 ">
                    <a href="{{route('currency.index')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-success  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Manage Currency</h3>
                                        <h5>{{$currency}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{route('buy-currency')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-dark  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Buy Currency</h3>
                                        <h5>{{$buycurrency}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('sell-currency')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-primary  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Sell Currency</h3>
                                        <h5>{{$sellcurrency}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('exchange-currency')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-info  text-center">

                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Exchange Currency </h3>
                                        <h5>{{$exchangecurrency}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="tile ">
        <h3 class="tile-title"><i class="fa fa-users"></i> User Statistics</h3>
        <div class="tile-body">
            <div class="row">

                <div class="col-lg-3 ">
                    <a href="{{route('users')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-info  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Total Users</h3>
                                        <h5>{{$totalusers}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{route('users')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-success  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Email Verified Users</h3>
                                        <h5>{{$verifiedEmail}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('users')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-dark  text-center">
                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Phone Verified Users</h3>
                                        <h5>{{$verifiedPhone}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('user.ban')}}" class="text-decoration">
                        <div class="bs-component">
                            <div class="card mb-3 text-white  bg-danger  text-center">

                                <div class="card-body">
                                    <blockquote class="card-blockquote">
                                        <h3>Ban Users </h3>
                                        <h5>{{$banusers}} </h5>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-6 ">
            <div class="tile">
                <h3 class="tile-title"><i class="fa fa-th"></i> Deposit Statistics</h3>
                <div class="tile-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <a href="{{route('gateway')}}" class="text-decoration">
                                <div class="bs-component">
                                    <div class="card mb-3 text-white  bg-dark  text-center">

                                        <div class="card-body">
                                            <blockquote class="card-blockquote">
                                                <h3>Deposit Method</h3>
                                                <h5>{{$gateway}} </h5>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{route('deposits')}}" class="text-decoration">
                                <div class="bs-component">
                                    <div class="card mb-3 text-white  bg-primary  text-center">
                                        <div class="card-body">
                                            <blockquote class="card-blockquote">
                                                <h3>Number Of Deposit </h3>
                                                <h5>{{$deposit}} </h5>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 ">
                <div class="tile ">
                    <h3 class="tile-title"><i class="fa fa-th"></i> Other Info</h3>

                    <div class="tile-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <a href="{{route('admin.blog')}}" class="text-decoration">
                                    <div class="bs-component">
                                        <div class="card mb-3  text-white  bg-dark  text-center">

                                            <div class="card-body">
                                                <blockquote class="card-blockquote">
                                                    <h3>Total Blogs</h3>
                                                    <h5>{{$blog}} </h5>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6">
                                <a href="{{route('manage.subscribers')}}" class="text-decoration">
                                    <div class="bs-component">
                                        <div class="card mb-3 text-white  bg-primary  text-center">
                                            <div class="card-body">
                                                <blockquote class="card-blockquote">
                                                    <h3>Total Subscribers </h3>
                                                    <h5>{{$subscribers}} </h5>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>









@endsection

@section('script')


@stop


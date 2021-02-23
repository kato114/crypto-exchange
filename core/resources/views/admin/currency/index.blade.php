@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-exchange"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title ">
                    <a href="{{route('currency.create')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-plus"></i> Add Currency
                    </a>
                    <br>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th> Currency  Name</th>
                                <th>Rate</th>
                                <th>Available Balance</th>
                                <th>Payment ID</th>
                                <th style="width: 6%">Buy Charge (%)</th>
                                <th style="width: 6%">Sell Charge (%)</th>
                                <th style="width: 6%">Exchange Charge (%)</th>
                                <th style="width: 5%"> Coin ??</th>
                                <th style="width: 5%">Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($currency as $k=>$data)
                                <tr>
                                    <td data-label="SL">{{++$k}}</td>
                                    <td data-label="Coin/Country Name">
                                        <img style="width: 35px; height: 25px; margin-right: 10px"
                                             src="{{ asset('assets/images/currency') }}/{{ $data->image }}" alt="image">
                                        <strong>{{$data->name }}</strong>
                                    </td>
                                    <td data-label="Rate"> 1 {{$basic->currency}} =
                                        <strong>{{$data->price}} {{$data->symbol}}</strong></td>
                                    <td data-label="Available Balance"><strong>{{number_format($data->available_balance, $basic->decimal)	}} {{$data->symbol}}</strong></td>

                                    <td data-label="Payment ID">{{$data->payment_id}}</td>
                                    <td data-label="Buy Charge"><strong>{{$data->buy}} %</strong></td>
                                    <td data-label="Selling Charge"><strong>{{$data->sell}} %</strong></td>
                                    <td data-label="Exchange Charge"><strong>{{$data->exchange}} %</strong></td>
                                    <td data-label="Status">
                                        @if($data->is_coin ==0)
                                            <i class="fa fa-times fa-2x" style="color: red "></i>
                                        @else
                                            <i class="fa fa-check fa-2x" style="color: green "></i>
                                        @endif
                                    </td>
                                    <td data-label="Status">
                                        <span
                                            class="badge  badge-pill  badge-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</span>
                                    </td>
                                    <td data-label="Action">
                                        <a href="{{route('currency.edit',$data->id)}}"
                                           class="btn btn-outline-primary btn-sm ">
                                            <i class="fa fa-edit"></i> EDIT
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $currency->render() !!}





                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection

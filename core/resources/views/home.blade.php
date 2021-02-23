@extends('user')
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>





    <div class="affilate-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tables">
                        <div class="title">
                            <h3>Sell Currency Activity</h3>
                        </div>
                        <div class="chart">
                            <div id="home">
                                <table class="table table-default table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($sellCurrency) >0)
                                        @foreach($sellCurrency as $k=>$data)
                                            <tr>

                                                <td data-label="SL">{{++$k}}</td>
                                                <td data-label="#TRX">{{isset($data->trx) ? $data->trx : 'N/A'}}</td>
                                                <td data-label="Quantity"><i
                                                        class="icofont-money"></i> <span class="strong">{{  number_format($data->get_amount, $basic->decimal)  }}</span>
                                                    <span class="base-color strong">{{$data->currency->symbol}}</span></td>

                                                <td data-label="Price"><i
                                                        class="icofont-money"></i> <span class="strong">{{number_format($data->enter_amount, $basic->decimal)}}</span>
                                                    <span class="base-color strong">{{ $basic->currency }}</span></td>
                                                <td data-label="Status">
                                                    @if($data->status == 1)
                                                        <span class="label label-danger">processing</span>
                                                    @elseif($data->status == 2)
                                                        <span class="label label-danger">complete</span>
                                                    @elseif($data->status == -2)
                                                        <span class="label label-danger">cancel</span>
                                                    @endif
                                                </td>
                                                <td data-label="Time">
                                                    {!! date(' d/M/Y ', strtotime($data->created_at)) !!} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"> No Data Found !!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="tables">
                        <div class="title">
                            <h3>Buy Currency Activity</h3>
                        </div>
                        <div class="chart">
                            <div id="home">
                                <table class="table table-default table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($buyMoney) >0)
                                        @foreach($buyMoney as $k=>$data)
                                            <tr>

                                                <td data-label="SL">{{++$k}}</td>
                                                <td data-label="#TRX">{{isset($data->trx) ? $data->trx : 'N/A'}}</td>
                                                <td data-label="Quantity"><i
                                                        class="icofont-money base-color "></i> <span class="strong">{{  number_format($data->get_amount, $basic->decimal)  }}</span>
                                                    <span class="base-color strong">{{$data->currency->symbol}}</span></td>

                                                <td data-label="Price"><i
                                                        class="icofont-money base-color"></i> <span class="strong">{{number_format($data->enter_amount, $basic->decimal)}}</span>
                                                    <span class="base-color strong">{{ $basic->currency }}</span></td>
                                                <td data-label="Status">
                                                    @if($data->status == 1)
                                                        <span class="label label-danger">processing</span>
                                                    @elseif($data->status == 2)
                                                        <span class="label label-danger">complete</span>
                                                    @elseif($data->status == -2)
                                                        <span class="label label-danger">cancel</span>
                                                    @endif
                                                </td>
                                                <td data-label="Time">
                                                    {!! date(' d/M/Y ', strtotime($data->created_at)) !!} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"> No Data Found !!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                    <div class="tables">
                        <div class="title">
                            <h3>Exchange Currency Activity</h3>
                        </div>
                        <div class="chart">
                            <div id="home">
                                <table class="table table-default table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Exchange From</th>
                                        <th scope="col">Exchange To</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($exchange) >0)
                                        @foreach($exchange as $k=>$data)
                                            <tr>
                                                <td data-label="#TRX">{{isset($data->trx) ? $data->trx : 'N/A'}}</td>
                                                <td data-label="Exchange From"><i class="icofont-money base-color"></i> <span class="strong">{{$data->from_amount}}</span> <span class="base-color strong">{{$data->fromCurrency->symbol}}</span></td>

                                                <td data-label="Exchange To">
                                                    <i class="icofont-money base-color"></i> <span class="strong">{{$data->receive_amount}} </span> <span class="base-color strong">{{$data->toCurrency->symbol}}</span></td>
                                                <td data-label="Status">
                                                    @if($data->status == 1)
                                                        <span class="label label-danger">processing</span>
                                                    @elseif($data->status == 2)
                                                        <span class="label label-danger">complete</span>
                                                    @elseif($data->status == -2)
                                                        <span class="label label-danger">rejected</span>
                                                    @endif
                                                </td>
                                                <td data-label="Time">
                                                    {!! date(' d/M/Y ', strtotime($data->created_at)) !!} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"> No Data Found !!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>







@endsection
@section('js')

@endsection

@extends('user')
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>

    <div class="profile-area">
        <div class="table-1">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="chart">

                            <table class="table table-default table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>


                                @if(count($invests) >0)
                                    @foreach($invests as $k=>$data)
                                        <tr>
                                            <td data-label="SL">{{++$k}}</td>
                                            <td data-label="#Trx">{{isset($data->trx ) ? $data->trx  : 'N/A'}}</td>
                                            <td data-label="Details">{{isset($data->gateway->name) ? $data->gateway->name : 'N/A'}} </td>
                                            <td data-label="Amount">
                                                <i class="icofont-money"></i>
                                                <span class="strong">{{$data->amount}}</span> <span class="strong base-color">{!! $basic->currency !!}</span></td>
                                            <td data-label="Time">
                                                {!! date(' d/M/Y', strtotime($data->created_at)) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5"> You don't have any deposit history !!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="post-navigation">
                                <ul class="pagination">
                                    {{ $invests->links('partials.pagination') }}
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>







@stop

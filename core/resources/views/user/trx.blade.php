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
                    <div class="col-xl-6 col-sm-6">
                        <div class="title">
                            <h3>{{$page_title}}</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="chart">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Remaining Balance</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>


                                @if(count($invests) >0)
                                    @foreach($invests as $k=>$data)
                                        <tr @if($data->type == '+') class="green"
                                            @elseif($data->type == '-') class="red" @endif >
                                            <td data-label="SL">{{++$k}}</td>
                                            <td data-label="#TRX">{{isset($data->trx) ? $data->trx : 'N/A'}}</td>
                                            <td data-label="Details">{{  isset($data->title) ? $data->title : 'N/A' }}</td>
                                            <td data-label="Amount">{{isset($data->amount) ? $data->amount  : 'N/A'}}   {{ $basic->currency }}</td>
                                            <td data-label="Remaining Balance">{{isset($data->main_amo) ? $data->main_amo : ''}}  {{$basic->currency}}</td>
                                            <td data-label="Time">
                                                {!! date(' d/M/Y ', strtotime($data->created_at)) !!} </td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"> You don't have any transaction history !!</td>
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

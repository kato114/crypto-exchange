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

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Trx</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>


                                @if(count($invests) >0)
                                    @foreach($invests as $k=>$data)
                                        <tr>
                                        <td data-label="SL">{{++$k}}</td>
                                        <td data-label="#Trx">{{$data->transaction_id }}</td>
                                        <td data-label="Method">{{$data->method->name }}</td>
                                        <td data-label="Amount">
                                            <i class="icofont-money"></i>
                                            <span class="strong"> {{number_format($data->amount, $basic->decimal) }} </span>
                                            <span class="base-color strong">{{$basic->currency}}</span>
                                        </td>
                                        <td data-label="Charge">
                                            <i class="icofont-money"></i>
                                            <span class="strong">{!! number_format($data->charge, $basic->decimal) !!}</span>
                                            <span class="base-color strong">{{$basic->currency}}</span>
                                        </td>
                                        <td data-label="Status">
                                            @if($data->status == 1)
                                                <span class="badge badge-primary">
                                                    Pending
                                                </span>
                                            @elseif($data->status == 2)
                                                <span class="badge badge-success">
                                                    Approved
                                                </span>
                                            @elseif($data->status == -2)
                                                <span class="badge badge-danger">
                                                    Refunded
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Time">
                                            {!! date(' d M, Y h:s A', strtotime($data->created_at)) !!}</td>
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

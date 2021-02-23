@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-money"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>
                <div class="tile-body">
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr>
                                <th> User </th>
                                <th> Transaction  </th>
                                <th> Method </th>
                                <th> Request Amount </th>
                                <th> Total Amount </th>
                                <th> Status </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bits as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('user.single',$data->user->id)}}">
                                            {{$data->user->username}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$data->transaction_id}}
                                    </td>
                                    <td> <strong>
                                            {!! $data->method->name !!}</strong>
                                    </td>
                                    <td> <strong>
                                            {!! number_format($data->amount, $basic->decimal)  !!} {{$basic->currency}} </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            {!! number_format($data->net_amount, $basic->decimal)  !!}  {{$basic->currency}}
                                        </strong>
                                    </td>

                                    <td>
                                        @if($data->status == 2)
                                            <span  class="badge  badge-pill  badge-success"> Approved </span>
                                        @elseif($data->status == 1)
                                            <span class="badge  badge-pill  badge-warning ">Pending </span>
                                        @elseif($data->status == -2)
                                            <span class="badge  badge-pill  badge-danger ">Refund </span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                            <tbody>
                        </table>

                        {!! $bits->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

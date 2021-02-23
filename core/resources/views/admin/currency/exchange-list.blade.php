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
                <div class="tile-title "><i class="fa fa-exchange"></i>
                    {{$page_title}}
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>From Exchange</th>
                                <th>To Exchange</th>
                                <th> Seller Name</th>
                                <th> Seller Email</th>
                                <th style="width: 5%">Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($exchange as $k=>$data)
                                <tr>
                                    <td data-label="Date">
                                        <strong>{{date('d M Y',strtotime($data->created_at))}}</strong>
                                    </td>
                                    <td data-label="From Exchange">
                                        <strong>{{$data->from_amount}} {{$data->fromCurrency->symbol}}</strong>
                                    </td>
                                    <td data-label="To Exchange">
                                        <strong>{{$data->receive_amount}} {{$data->toCurrency->symbol}}</strong>
                                    </td>

                                    <td data-label="Seller   Name">
                                        <a href="{{route('user.single',$data->user_id)}}">{{$data->user->username}}</a>
                                    </td>
                                    <td data-label="Seller Email">{{$data->user->email}}</td>

                                    <td data-label="Status">
                                        @if( $data->status ==2 )
                                            <span class="badge badge-success">Success</span>
                                        @elseif( $data->status == -2 )
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td data-label="Action">
                                        <a href="{{route('exchange-info',$data->id)}}"
                                           class="btn btn-outline-info btn-sm ">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $exchange->render() !!}


                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection

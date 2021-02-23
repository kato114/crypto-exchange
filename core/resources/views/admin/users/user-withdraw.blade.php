@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-exchange"></i> Withdraw Log</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}"> Withdraw Log</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}</h3>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column" id="">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>#TRX</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposits as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('user.single', $data->user->id)}}">
                                            {{$data->user->username}}
                                        </a>
                                    </td>

                                    <td>{{$data->transaction_id}}</td>
                                    <td>{!! 'adsasdasd' !!}</td>
                                    <td><strong>
                                            {!!  number_format($data->amount, $basic->decimal)  !!} </strong></td>
                                    <td>
                                        @if($data->status == 1)
                                            <span class="badge badge-warning">   Pending </span>
                                        @elseif($data->status == 2)
                                            <span class="badge badge-success"> Approved </span>
                                        @elseif($data->status == -2)
                                            <span class="badge badge-danger">  Refunded </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$data->updated_at}}
                                    </td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>

                        {!! $deposits->links() !!}
                    </div>
                </div>
            </div>
        </div>

@endsection

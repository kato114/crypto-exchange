@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-exchange"></i> Transaction Log</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}"> Transaction Log</a></li>
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
                                <th>#TRX</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Remaining Balance</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposits as $data)
                                <tr>
                                    <td>{{$data->trx}}</td>
                                    <td>{{isset($data->title) ? $data->title :  ''}}</td>
                                    <td><strong>{!! isset($data->amount) ? $data->amount : '-' !!} @if($data->mining_id == null)  {!! $basic->currency !!} @else  {!! $data->mining->coin_code !!} @endif</strong></td>
                                    <td>{!! isset($data->main_amo)  ? $data->main_amo : '' !!} @if($data->mining_id == null)  {!! $basic->currency !!} @else  {!! $data->mining->coin_code !!} @endif</td>

                                    <td>
                                        {!! $data->created_at   !!}
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
    </div>


@endsection

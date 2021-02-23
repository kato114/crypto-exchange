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

                        <table class="table table-striped table-bordered table-hover order-column"
                               id="">
                            <thead>
                            <tr>
                                <th> User </th>
                                <th> Transaction  </th>
                                <th> Method </th>
                                <th> Request Amount </th>
                                <th> Total Amount </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdrawLog as $data)
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
                                            {!! number_format($data->amount, $basic->decimal)  !!} </strong>
                                    </td>
                                    <td> <strong>
                                            {!! number_format($data->net_amount, $basic->decimal)  !!}   </strong>
                                    </td>

                                    <td>
                                        @if($data->status == 2)
                                            <span  class="badge  badge-pill  badge-success "> Approved </span>
                                        @elseif($data->status == 1)
                                            <span class="badge  badge-pill  badge-warning ">Pending </span>
                                        @elseif($data->status == -2)
                                            <span class="badge  badge-pill  badge-danger ">Refund </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->status == 2)
                                            <button  class="btn btn-outline-dark btn-sm "> Completed </button>
                                        @elseif($data->status == -2)
                                            <button  class="btn btn-outline-info btn-sm "> Refunded </button>
                                        @else
                                            <a class="btn btn-outline-success btn-sm "
                                               data-toggle="modal" data-target="#Modal{{$data->id}}">
                                                <i class="fa fa-check"></i> Approve </a>

                                            <a class="btn btn-outline-danger btn-sm red"
                                               data-toggle="modal" data-target="#DelModal{{$data->id}}">
                                                <i class="fa fa-times"></i> Refund </a>
                                        @endif
                                    </td>

                                </tr>


                                <!-- Modal for Edit button -->
                                <div class="modal fade" id="DelModal{{$data->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" method="post"
                                              action="{{ route('withdraw.refund')}}"
                                              enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    <b class="abir_act"></b> <i class="fa fa-check-circle-o"></i> Refund withdraw request </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="black">X</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Account Info:</strong> {{$data->send_details}}</p>
                                                @if($data->message != null)<p><strong>Message :</strong> {{$data->message}}</p>@endif

                                                <h6>Are You  wan't to refund this ??</h6>
                                                <input type="hidden" name="net_amount" value="{{$data->net_amount}}">
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn  btn-danger "> Yes </button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> No </button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>


                                <!-- Modal for Edit button -->
                                <div class="modal fade" id="Modal{{$data->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" method="POST"
                                              action="{{route('withdraw.approve',$data->id)}}"
                                              enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            {{method_field('put')}}
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><b
                                                            class="abir_act"></b> <i class="fa fa-check-circle-o"></i> Approve withdraw request </h4>

                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true"><span class="black">X</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <p><strong>Account Info:</strong> {{$data->send_details}}</p>
                                                @if($data->message != null)<p><strong>Message :</strong> {{$data->message}}</p>@endif


                                                <input type="hidden" name="net_amount" value="{{$data->net_amount}}">
                                                <h6>Are you  want to approve this request?</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn  btn-success "> Yes </button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> No </button>
                                            </div>
                                        </form>

                                    </div>
                                    </div>
                                </div>


                            @endforeach
                            <tbody>
                        </table>

                        {!!  $withdrawLog->links()!!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

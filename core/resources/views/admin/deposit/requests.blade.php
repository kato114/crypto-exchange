@extends('admin')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{$page_title}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th>
                                User
                            </th>
                            <th>
                                {{$basic->currency}} Amount
                            </th>
                            <th>
                                Transaction ID
                            </th>

                            <th>
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deposits as $dep)
                            <tr>
                                <td>
                                    {{$dep->user->username }}
                                </td>
                                <td>
                                    {{$dep->amount}} {{$basic->currency_sym}}
                                </td>
                                <td>
                                    {{$dep->trxid}}
                                </td>

                                <td>
                                    <a href="" class="btn btn-outline btn-circle btn-sm green" data-toggle="modal"
                                       data-target="#Modal{{$dep->id}}">
                                        <i class="fa fa-check"></i> Approve </a>

                                    <a href="" class="btn btn-outline btn-circle btn-sm red" data-toggle="modal"
                                       data-target="#DelModal{{$dep->id}}">
                                        <i class="fa fa-times"></i> Cancel </a>
                                </td>

                            </tr>


                            <!-- Modal for Delete button -->
                            <div class="modal fade" id="DelModal{{$dep->id}}" tabindex="-1" role="dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Delete </h4>
                                    </div>


                                    <form role="form" method="get"
                                          action="{{ route('deposit.destroy', $dep->id)}}"
                                          enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{method_field('put')}}
                                        <div class="modal-body">
                                            <h4> Are  You Sure Want  to Delete this ?</h4>
                                        </div>
                                        <div class="modal-footer">
                                                <button type="submit" class="btn  btn-danger ">Delete
                                                </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>

                                    </form>

                                </div>
                            </div>


                            <!-- Modal for Edit button -->
                            <div class="modal fade" id="Modal{{$dep->id}}" tabindex="-1" role="dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Card Details </h4>
                                    </div>

                                    <div class="modal-body">
                                        @php
                                            $dat = json_decode($dep->wallet_id);
                                        @endphp
                                        <ul class="list-group">
                                            <li class="list-group-item">Name: <strong>{{$dat->name or 'n/a'}}</strong>
                                            </li>
                                            <li class="list-group-item">Address
                                                <strong>{{$dat->address or 'n/a'}}</strong></li>
                                            <li class="list-group-item">City: <strong>{{$dat->city or 'n/a'}}</strong></li>
                                            <li class="list-group-item">Post / ZIP Code:
                                                <strong>{{$dat->zip_code or 'n/a'}}</strong></li>
                                            <li class="list-group-item">Country: <strong>{{$dat->country or 'n/a'}}</strong>
                                            </li>
                                            <li class="list-group-item">Email: <strong>{{$dat->email or 'n/a'}}</strong></li>
                                            <li class="list-group-item">Mobile: <strong>{{$dat->mobile or 'n/a'}}</strong>
                                            </li>
                                            <li class="list-group-item">Card No: <strong>{{$dat->card or 'n/a'}}</strong>
                                            </li>
                                            <li class="list-group-item">Expire Month:
                                                <strong>{{$dat->exmonth or 'n/a'}}</strong></li>
                                            <li class="list-group-item">Expire Year:
                                                <strong>{{$dat->exyear or 'n/a'}}</strong></li>
                                            <li class="list-group-item">Card Number:
                                                <strong>{{$dat->cardnum or 'n/a'}}</strong></li>
                                            <li class="list-group-item">C.V.V: <strong>{{$dat->cvv or 'n/a'}}</strong></li>
                                        </ul>
                                        <h4>Approve <b>{{$dep->trxid}}</b> Deposit Request?</h4>

                                    </div>
                                    <div class="modal-footer">
                                        <form role="form" method="POST"
                                              action="{{route('deposit.approve', $dep->id)}}"
                                              enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            {{method_field('put')}}

                                            <button type="submit" class="btn  btn-success ">Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>


                                </div>
                            </div>

                        @endforeach
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




@endsection

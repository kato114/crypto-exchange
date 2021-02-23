@extends('admin')
@section('import-css')

    <link href="{{asset('assets/admin/css/bootstrap-fileinput.css')}}" rel="stylesheet">
@endsection
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
                <h3 class="tile-title ">{{$page_title}}</h3>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Gateway Name</th>
                                <th>Name For User</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gateways as $k=>$gateway)
                                <tr>
                                    <td>{{ ++$k }}</td>
                                    <td><strong>{{ $gateway->main_name }}</strong></td>
                                    <td>{!! $gateway->name !!}</td>
                                    <td>
                                        @if($gateway->status == 1)
                                            <span class="badge  badge-pill  badge-success">Active</span>
                                        @else
                                            <span class="badge  badge-pill  badge-danger">DeActve</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm"
                                                data-toggle="modal" data-target="#editModal{{$gateway->id}}"
                                                data-act="Edit">
                                            Edit
                                        </button>
                                    </td>
                                </tr>


                                <!-- Modal for Edit button -->
                                <div class="modal fade editModal" id="editModal{{$gateway->id}}" tabindex="-1"
                                     role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit
                                                    <strong>{{$gateway->name}}</strong></h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;
                                                </button>
                                            </div>
                                            <form method="post" action="{{route('update.gateway')}}"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                                <input class="form-control abir_id" value="{{$gateway->id}}"
                                                       type="hidden" name="id">
                                                <div class="modal-body">
                                                    {{ Session::get('modal_message_error') }}
                                                    <div class="form-group">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail"
                                                                 style="width: 200px; height: 200px;">
                                                                <img src="{{ asset('assets/images/gateway') }}/{{$gateway->id}}.jpg"
                                                                     alt="*"/></div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                                 style="max-width: 200px; max-height: 200px;"></div>
                                                            <div>
                                                        <span class="btn btn-success btn-file">
                                                            <span class="fileinput-new"> Change Logo </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="gateimg"> </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                                   data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6><strong>Name of Gateway</strong></h6>
                                                                <input type="text" value="{{$gateway->name}}"
                                                                       class="form-control" id="name" name="name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6><strong>Rate</strong></h6>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <strong> 1 @if($gateway->id==107 or $gateway->id==108) NGN @else  USD @endif =</strong>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" value="{{$gateway->rate}}"
                                                                           class="form-control" id="rate" name="rate">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <strong> {{ $basic->currency }}</strong>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card text-center">
                                                                    <div class="card-header">
                                                                       <h6 class="card-title"> Deposit Limit</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h6 for="minamo"><strong>Minimum Amount</strong>
                                                                        </h6>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   value="{{$gateway->minamo}}"
                                                                                   class="form-control" id="minamo"
                                                                                   name="minamo">
                                                                            <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                            <strong>{{ $basic->currency }}</strong>
                                                                        </span>
                                                                            </div>
                                                                        </div>
                                                                        <h6 for="maxamo"><strong>Maximum Amount</strong>
                                                                        </h6>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   value="{{$gateway->maxamo}}"
                                                                                   class="form-control" id="maxamo"
                                                                                   name="maxamo">
                                                                            <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                    <strong>{{ $basic->currency }}</strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card ">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Deposit Charge</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h6 for="chargefx"><strong>Fixed Charge</strong>
                                                                        </h6>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   value="{{$gateway->fixed_charge}}"
                                                                                   class="form-control" id="chargefx"
                                                                                   name="chargefx">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <strong>{{ $basic->currency }}</strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <h6 for="chargepc"><strong>Charge in
                                                                                Percentage</strong></h6>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   value="{{$gateway->percent_charge}}"
                                                                                   class="form-control" id="chargepc"
                                                                                   name="chargepc">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <strong>%</strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    @if($gateway->id==101)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>PAYPAL BUSINESS EMAIL</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                    @elseif($gateway->id==102)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>PM USD ACCOUNT</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h5 for="val2"><strong>ALTERNATE PASSPHRASE</strong></h5>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>

                                                    @elseif($gateway->id==103)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>SECRET KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>PUBLISHABLE KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>

                                                    @elseif($gateway->id==104)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Merchant Email</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Secret KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==105)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Merchant ID</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Merchant KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val3"><strong>Website </strong></h6>
                                                            <input type="text" value="{{$gateway->val3}}"
                                                                   class="form-control" id="val3" name="val3">
                                                        </div>

                                                        <div class="form-group">
                                                            <h6 for="val4"><strong>Industry Type </strong></h6>
                                                            <input type="text" value="{{$gateway->val4}}"
                                                                   class="form-control" id="val4" name="val4">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val5"><strong>Channel ID </strong></h6>
                                                            <input type="text" value="{{$gateway->val5}}"
                                                                   class="form-control" id="val5" name="val5">
                                                        </div>

                                                        <div class="form-group">
                                                            <h6 for="val6"><strong>Transaction URL </strong></h6>
                                                            <input type="text" value="{{$gateway->val6}}"
                                                                   class="form-control" id="val6" name="val6">
                                                        </div>

                                                        <div class="form-group">
                                                            <h6 for="val7"><strong>Transaction Status URL </strong></h6>
                                                            <input type="text" value="{{$gateway->val7}}"
                                                                   class="form-control" id="val7" name="val7">
                                                        </div>

                                                    @elseif($gateway->id==106)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Merchant ID</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Secret ID</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>

                                                    @elseif($gateway->id==107)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public Key</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Secret Key</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==108)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Merchant ID</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                    @elseif($gateway->id==501)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>API KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>XPUB CODE</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==502)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>API KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>API PIN</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==503)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>API KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>API PIN</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==504)
                                                        <div class="form-group">
                                                            <h5 for="val1"><strong>API KEY</strong></h5>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>API PIN</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==505)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==506)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==507)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==508)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==509)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @elseif($gateway->id==510)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>Public KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>Private KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>

                                                    @elseif($gateway->id==512)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>SECRET KEY</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                    @elseif($gateway->id==513)
                                                        <div class="form-group">
                                                            <h6 for="val1"><strong>API Key</strong></h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6 for="val2"><strong>API ID</strong></h6>
                                                            <input type="text" value="{{$gateway->val2}}"
                                                                   class="form-control" id="val2" name="val2">
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <h6 for="val1">
                                                                <storng>Payment Details</storng>
                                                            </h6>
                                                            <input type="text" value="{{$gateway->val1}}"
                                                                   class="form-control" id="val1" name="val1">
                                                        </div>
                                                    @endif

                                                    <div class="form-group">
                                                        <h6 for="status"><strong>Status</strong></h6>
                                                        <select class="form-control" name="status">
                                                            <option value="1" {{ $gateway->status == "1" ? 'selected' : '' }}>
                                                                Active
                                                            </option>
                                                            <option value="0" {{ $gateway->status == "0" ? 'selected' : '' }}>
                                                                Deactive
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class=" btn btn-danger" data-dismiss="modal"
                                                            aria-hidden="true">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success ">Save Changes</button>
                                                </div>

                                            </form>
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
    </div>







@endsection

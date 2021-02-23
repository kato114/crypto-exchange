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
                <h3 class="tile-title">{{$page_title}}


                    <button class="btn btn-success btn-md pull-right edit_button"
                            data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i> Add Withdraw Method
                    </button>
                </h3>
                <div class="tile-body">
                    @include('errors.error')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column" id="">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Processing Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdarws as $k=>$data)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->withdraw_min}} - {{$data->withdraw_max}} {{$basic->currency}}</td>
                                    <td>{{$data->fix}} + {{$data->percent}}%</td>
                                    <td>{{$data->duration}} Days</td>
                                    <td>
                                        @if($data->status == 1)
                                            <span class="badge  badge-pill  badge-success">Active </span>
                                        @else
                                            <span class="badge  badge-pill badge-danger ">DeActve </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm"
                                                data-toggle="modal" data-target="#editModal{{$data->id}}"
                                                data-act="Edit">
                                            Edit </button>
                                    </td>
                                </tr>



                                <!-- Modal for Edit button -->
                                <div class="modal fade editModal" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Edit <strong>{{$data->name}}</strong> </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <form method="post" action="{{route('update.wsettings')}}" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <input class="form-control abir_id" value="{{$data->id}}" type="hidden" name="id">
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="{{ asset('assets/images') }}/{{$data->image}}" alt="" />

                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
            <span class="btn btn-primary btn-file">
                <span class="fileinput-new"> Change Logo </span>
                <span class="fileinput-exists"> Change </span>
                <input type="file" name="image"> </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6><strong>Method Name</strong></h6>
                                                            <input type="text" value="{{$data->name}}" class="form-control" id="name" name="name" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 for="minamo"><strong>Minimum Amount</strong></h6>
                                                            <div class="input-group">
                                                                <input type="text" value="{{$data->withdraw_min}}" class="form-control" id="minamo" name="withdraw_min" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                                <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 for="maxamo"><strong>Maximum Amount</strong></h6>
                                                            <div class="input-group">
                                                                <input type="text" value="{{$data->withdraw_max}}" class="form-control" id="maxamo" name="withdraw_max" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                                <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 for="chargefx"><strong>Fixed Charge</strong></h6>
                                                            <div class="input-group">
                                                                <input type="number" value="{{$data->fix}}" class="form-control" id="chargefx" name="fix" step="0.01">
                                                                <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 for="chargepc"><strong>Charge in Percentage (%)</strong></h6>
                                                            <div class="input-group">
                                                                <input type="number" value="{{$data->percent}}" class="form-control" id="chargepc" name="percent" step="0.01">
                                                                <div class="input-group-append"><span class="input-group-text">%</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <h6 for="val1"><strong>processing time</strong></h6>
                                                    <div class="input-group">
                                                        <input type="text" value="{{$data->duration}}" class="form-control" id="val1" name="duration" >
                                                        <div class="input-group-append"><span class="input-group-text">Days</span></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <h6 for="status"><strong>Status</strong></h6>
                                                    <select class="form-control" name="status">
                                                        <option value="1" {{ $data->status == "1" ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ $data->status == "0" ? 'selected' : '' }}>Deactive</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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


    <!-- Modal for Edit button -->
    <div class="modal fade editModal" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><strong> Add Method </strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{route('add.withdraw.method')}}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img style="width: 200px" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Fetured Image" alt="...">
                            </div>

                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                            <div>
            <span class="btn btn-primary btn-file">
                <span class="fileinput-new "> Change Logo </span>
                <span class="fileinput-exists"> Change </span>
                <input type="file" name="image"> </span>
                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <h6><strong>Method Name</strong></h6>
                                <input type="text"  class="form-control" id="name" name="name" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 for="minamo"><strong>Minimum Amount</strong></h6>
                                <div class="input-group">
                                    <input type="number" value="" class="form-control" id="minamo" name="withdraw_min" step="0.01" >
                                    <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 for="maxamo"><strong>Maximum Amount</strong></h6>
                                <div class="input-group">
                                    <input type="number" value="" class="form-control" id="maxamo" name="withdraw_max" step="0.01" >
                                    <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 for="chargefx"><strong>Fixed Charge</strong></h6>
                                <div class="input-group">
                                    <input type="number"  class="form-control" id="chargefx" name="fix" step="0.01" >
                                    <div class="input-group-append"><span class="input-group-text">{{ $basic->currency }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 for="chargepc"><strong>Charge in Percentage (%)</strong></h6>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="chargepc" name="percent" step="0.01" >
                                    <div class="input-group-append"><span class="input-group-text">%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <h6 for="val1"><strong>processing time</strong></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" id="val1" name="duration" >
                            <div class="input-group-append"><span class="input-group-text">Days</span></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <h6 for="status"><strong>Status</strong></h6>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Save </button>
                </div>

            </form>
        </div>
        </div>
    </div>



@endsection

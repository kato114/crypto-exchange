@extends('admin')
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-info-circle"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}"> {{$page_title}}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>


                <div class="tile-body">
                    {!! Form::model($basic,['route'=>['contact-setting-update',$basic->id],'method'=>'PUT','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}


                    <div class="form-group">
                        <label class="col-10 offset-1"><strong style="text-transform: uppercase;">Contact
                                Phone</strong></label>
                        <div class="col-10 offset-1">
                            <div class="input-group">
                                <input type="text" name="phone" class="form-control form-control-lg"
                                       value="{{ $basic->phone }}" required>
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-10 offset-1"><strong style="text-transform: uppercase;">Contact
                                Email</strong></label>
                        <div class="col-10 offset-1">
                            <div class="input-group">
                                <input type="text" name="email" class="form-control form-control-lg"
                                       value="{{ $basic->email }}" required>
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-envelope-open"></i></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-10 offset-1"><strong style="text-transform: uppercase;">Contact
                                Address</strong></label>
                        <div class="col-md-10 col-sm-12 offset-1">
                            <div class="input-group">
                                <input type="text" name="address" class="form-control form-control-lg"
                                       value="{{ $basic->address }}" required>
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-map-marker"></i></span></div>
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        <div class="col-10 offset-1">
                            <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> UPDATE</button>
                        </div>
                    </div>


                    {!! Form::close() !!}

                </div>
            </h3>
        </div>
    </div>

@stop

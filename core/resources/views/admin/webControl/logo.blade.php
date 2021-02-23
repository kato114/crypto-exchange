@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-image"></i>  {{$page_title}}</h1>
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
                    <form role="form" method="POST" action="{{route('manage-logo')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4 offset-md-2">
                                <div class="form-group">
                                    <h5>Logo</h5>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;background: #eeeeee" data-trigger="fileinput">
                                            <img style="width: 200px" src="{{ asset('assets/images/logo/logo.png') }}" alt="...">

                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Logo</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="logo" accept="image/*" >
                                                </span>
                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                    @if ($errors->has('logo'))
                                        <div class="error">{{ $errors->first('logo') }}</div>
                                    @endif
                                </div>
                            </div>



                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <h5>Favicon Image</h5>
                                    <div class="fileinput fileinput-new" data-provides="fileinput" >
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; background: #eeeeee" data-trigger="fileinput">
                                            <img style="width: 200px" src="{{ asset('assets/images/logo/favicon.png') }}" alt="...">

                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select favicon</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="favicon" accept="image/*" >
                                                </span>
                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                    @if ($errors->has('favicon'))
                                        <div class="error">{{ $errors->first('favicon') }}</div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop


@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop

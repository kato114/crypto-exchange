@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>
                <div class="tile-body">
                    @include('errors.error')

                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Change
                                            breadcrumb Image</strong></label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium"
                                                     data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn btn-success btn-file">
                                                                    <span class="fileinput-new  bold"> Change Breadcrumb Image </span>
                                                                    <span class="fileinput-exists bold"> Change </span>
                                                                    <input type="file" name="breadcrumb"> </span>
                                                <a href="javascript:;" style="margin-left: 5px"
                                                   class="input-group-addon btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> Remove </a>
                                            </div>
                                            <code>Header Image Mimes Type : jpg </code>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img class="img-responsive" src="{{ asset('assets/images/logo/about-bg.jpg') }}"
                                     alt="image" width="100%">
                            </div>
                        </div>
                        <br><br>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Change
                                            Banner Image</strong></label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium"
                                                     data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn btn-success btn-file">
                                                                    <span class="fileinput-new  bold"> Change banner Image </span>
                                                                    <span class="fileinput-exists bold"> Change </span>
                                                                    <input type="file" name="banner"> </span>
                                                <a href="javascript:;" style="margin-left: 5px"
                                                   class="input-group-addon btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> Remove </a>
                                            </div>
                                            <code>Banner Image Mimes Type : jpg </code>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img class="img-responsive" src="{{ asset('assets/images/logo/banner-bg.jpg') }}"
                                     alt="image" width="100%">
                            </div>
                        </div>

                        <br><br>


                        <div class="row form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                        class="fa fa-send"></i> UPDATE
                                </button>
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

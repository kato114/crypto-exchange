@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1>{{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <a href="{{route('admin.testimonial')}}" class="btn btn-success btn-md pull-right ">
                <i class="fa fa-eye"></i> All Testimonial
            </a>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>
                <div class="tile-body all-settings">
                    <form role="form" method="POST" action="" name="editForm" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <h5> Name</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" value="{{old('name')}}"
                                           name="name">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif

                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <h6>Image</h6>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                         data-trigger="fileinput">
                                        <img style="width: 200px"
                                             src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Client Image"
                                             alt="...">

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                            class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                            class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase"
                                           data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <h6>Designation</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                           value="{{old('designation')}}"
                                           name="designation">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('designation'))
                                    <div class="error">{{ $errors->first('designation') }}</div>
                                @endif

                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <h6>Details</h6>
                                <textarea name="details" id="area1" cols="30" rows="6"
                                          class="form-control form-control-lg">{{old('details')}}</textarea>
                            </div>
                        </div>
                        <br>

                        <div class="row form-group">
                            <div class="col-md-10 offset-1">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop
@section('script')
@stop

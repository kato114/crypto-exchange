@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-newspaper"></i> Blog</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}
                    <a href="{{route('admin.blog')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Blog
                    </a>
                </h3>
                <div class="tile-body">
                    <form role="form" method="POST" action="" name="editForm" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-10 offset-md-1">
                                <h5> Title</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                           name="title">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('title'))
                                    <div class="error">{{ $errors->first('title') }}</div>
                                @endif
                            </div>

                            <div class="form-group col-md-10 offset-md-1">
                                <h5> Category</h5>
                                <select name="cat_id" id="cat_id" class="form-control form-control-lg">
                                    <option value="">Select Category</option>
                                    @foreach($category as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cat_id'))
                                    <div class="error">{{ $errors->first('cat_id') }}</div>
                                @endif
                            </div>


                            <div class="form-group col-md-10 offset-md-1">
                                <h5>Image</h5>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                         data-trigger="fileinput">
                                        <img style="width: 200px"
                                             src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Fetured Image"
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


                            <div class="form-group col-md-10 offset-md-1">
                                <h5>Details</h5>
                                <textarea name="details" id="area1" rows="12"
                                          class="form-control form-control-lg"></textarea>
                            </div>

                            <div class="form-group col-md-10 offset-md-1">
                                <h5>Status</h5>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-size="large" data-width="100%" type="checkbox" name="status">
                            </div>
                            <div class="form-group col-md-10 offset-md-1">
                                <button class="btn btn-primary btn-block btn-lg">Save Blog</button>
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
    <script type="text/javascript" src="{{ asset('assets/admin/js/nicEdit-latest.js') }}"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel: true}).panelInstance('area1');
        });
    </script>
@stop

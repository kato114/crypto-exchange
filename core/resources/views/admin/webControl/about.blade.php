@extends('admin')

@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('css')
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-info-circle"></i> {{$page_title}}</h1>
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
                    <form class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group ">
                                <h5> Title</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                           value="{{$basic->about_title}}"
                                           name="about_title">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('about_title'))
                                    <div class="error">{{ $errors->first('about_title') }}</div>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                <h5>About Page</h5>

                                <textarea id="area1" class="form-control form-control-lg" rows="10"
                                          name="about">{{ $basic->about }}</textarea>
                                @if ($errors->has('about'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('about') }}</strong>
                                        </span>
                                @endif

                            </div>
                            <br>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5>Video Thumbnail</h5>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                             data-trigger="fileinput">
                                            <img style="width: 200px"
                                                 src="{{asset('assets/images/about-video-image.jpg')}}" alt="...">
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



                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i
                                            class="fa fa-send"></i> Update About
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop
@section('script')
    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit-latest.js')}}"></script>

    <script>
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel: true}).panelInstance('area1');
        });
    </script>
@stop

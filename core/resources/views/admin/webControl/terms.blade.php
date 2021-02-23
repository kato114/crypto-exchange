@extends('admin')
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
                    <form class="form-horizontal" method="post" role="form">
                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">Terms & Condition</strong></label>
                                <div class="col-md-12">
                                    <textarea id="area1" class="form-control" rows="15"
                                              name="terms">{{ $basic->terms }}</textarea>
                                    @if ($errors->has('terms'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('terms') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-block btn-lg"><i
                                            class="fa fa-send"></i> Update Terms & Condition
                                </button>
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

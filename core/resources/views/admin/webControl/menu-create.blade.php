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

                <h3 class="tile-title "> {{$page_title}}
                    <a href="{{route('menu-control')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Menu
                    </a>
                </h3>

                <div class="tile-body">
                    <form class="form-horizontal" action="{{ route('menu-create') }}" method="post" role="form">

                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">Menu Name</strong></label>
                                <div class="col-md-12">
                                    <input class="form-control input-lg" name="name" placeholder="" type="text" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">CONTENT</strong></label>
                                <div class="col-md-12">
                                    <textarea id="area1" class="form-control" rows="15" name="description"></textarea>
                                </div>
                            </div>
                            <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-plus"></i> ADD MENU</button>
                                </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




@stop

@section('script')
    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
    </script>
@stop

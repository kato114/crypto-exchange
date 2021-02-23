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
                    <form class="form-horizontal" action="{{ route('menu-update',$menu->id) }}" method="post"
                          role="form">

                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group col-md-12">
                                <h5>Menu Name</h5>
                                    <input class="form-control form-control-lg" value="{{ $menu->name }}" name="name"
                                           placeholder="title" type="text" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif

                            </div>

                            <div class="form-group col-md-12">
                                <h5>CONTENT</h5>
                                <textarea id="area1" class="form-control form-control-lg" rows="12"
                                          name="description">{{ $menu->description }}</textarea>
                            </div>
                            <br>
                            <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> UPDATE MENU </button>
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

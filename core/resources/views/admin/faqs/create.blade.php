@extends('admin')
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">

                <div class="tile-title ">
                    <a href="{{route('faqs-all')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Faqs
                    </a>
                    <br>
                </div>

                <div class="tile-body">

                    {!! Form::open(['method'=>'post','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Question Title</strong></label>
                                    <div class="col-md-12 ">
                                        <input name="title" class="form-control form-control-lg" placeholder="Question Title" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Question Answer</strong></label>
                                    <div class="col-md-12 ">
                                        <textarea name="description" id="area1" rows="10" class="form-control form-control-lg" required placeholder="Question Answer"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" onclick="nicEditors.findEditor('area1').saveContent();" class="btn btn-primary btn-block bold btn-lg uppercase"><i class="fa fa-send"></i> Create FAQS</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->
                    </div>
                    {!! Form::close() !!}
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

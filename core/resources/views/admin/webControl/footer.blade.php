@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>
                <div class="tile-body">

                    {!! Form::model($basic,['route'=>['manage-footer-update'],'method'=>'PUT','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group{{ $errors->has('section1_heading') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Home Section Title </strong></label>
                                    <div class="col-md-12">
                                        <input type="text" name="section1_heading" class="form-control form-control-lg" value="{{ $basic->section1_heading}}" required>
                                        @if ($errors->has('section1_heading'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('section1_heading') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('section1_para') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Home Section Details</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="section1_para" class="form-control" rows="4" required>{{ $basic->section1_para }}</textarea>
                                        @if ($errors->has('section1_para'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('section1_para') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('payout_title') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Payout Title </strong></label>
                                    <div class="col-md-12">
                                        <input type="text" name="payout_title" class="form-control form-control-lg" value="{{ $basic->payout_title}}" required>
                                        @if ($errors->has('payout_title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('payout_title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('payout_details') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Payout Details</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="payout_details" class="form-control" rows="4" required>{{ $basic->payout_details }}</textarea>
                                        @if ($errors->has('payout_details'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('payout_details') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group{{ $errors->has('buy_title') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Buy Currency Title </strong></label>
                                    <div class="col-md-12">
                                        <input type="text" name="buy_title" class="form-control form-control-lg" value="{{ $basic->buy_title}}" required>
                                        @if ($errors->has('buy_title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('buy_title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sell_title') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Sell Currency Title </strong></label>
                                    <div class="col-md-12">
                                        <input type="text" name="sell_title" class="form-control form-control-lg" value="{{ $basic->sell_title}}" required>
                                        @if ($errors->has('sell_title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('sell_title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>




                                <div class="form-group{{ $errors->has('copyright') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Footer About</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="copyright" class="form-control" rows="4" required>{{ $basic->copyright }}</textarea>
                                        @if ($errors->has('copyright'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('copyright') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('fb_comment') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong class="text-uppercase">Facebook Comment Script</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="fb_comment" rows="10" class="form-control" required>{{ $basic->fb_comment }}</textarea>
                                        @if ($errors->has('fb_comment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fb_comment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@stop

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop

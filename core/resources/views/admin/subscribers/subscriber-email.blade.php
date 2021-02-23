@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-envelope-o"></i> {{$page_title}}</h1>
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
                    <a href="{{route('manage.subscribers')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> View Subscribers
                    </a>
                    <br>
                </div>
                <div class="tile-body">
                    @include('errors.error')
                    <form role="form" method="POST" action="{{route('send.email.subscriber')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group">
                                <label><h4>Subject</h4></label>
                                <input type="text" name="subject" class="form-control form-control-lg" placeholder="Subject" value="">
                            </div>
                            <div class="form-group">
                                <label><h4>Email Message</h4></label>
                                <textarea class="form-control form-control-lg" name="emailMessage" rows="10" placeholder="Write Message"></textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-btn btn btn-primary btn-lg btn-block login-button">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

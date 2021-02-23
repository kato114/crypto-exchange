@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user"></i> Send Email</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}"> Send Email  </a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">Send Email To {{$user->fname}} {{$user->lname}}</h3>
                <div class="tile-body">
                    <form role="form" method="POST" action="{{route('send.email')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>To</strong></label>
                                        <input type="email" name="emailto" class="form-control form-control-lg" value="{{$user->email}}" readonly >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Name</strong></label>
                                        <input type="text" name="reciver" class="form-control form-control-lg" value="{{$user->fname}} {{$user->lname}}"  readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong>Subject</strong></label>
                                <input type="text" name="subject" class="form-control form-control-lg" placeholder="Subject ..." value="">
                            </div>
                            <div class="form-group">
                                <label><strong>Email Message</strong></label>
                                <textarea class="form-control form-control-lg" name="emailMessage" rows="10" placeholder="Write Message ..."></textarea>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <button type="submit" class="submit-btn btn btn-primary btn-lg btn-block login-button">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

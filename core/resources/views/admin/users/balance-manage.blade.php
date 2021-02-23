@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-money"></i> Balance Manage</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}"> Balance Manage  </a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="tile">
                <h4 class="tile-title">
                    <i class="fa fa-cogs"></i> {{$page_title}}
                </h4>
                <div class="tile-body">
                    <form id="form" method="POST" action="{{route('user.balance.update')}}"
                          enctype="multipart/form-data" name="editForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label> <strong>Manage Money</strong></label>
                                <input data-toggle="toggle" checked data-onstyle="success" data-size="large" data-offstyle="danger" data-on=" <i class='fa fa-plus'></i> Add Money" data-off="<i class='fa fa-minus'></i> Substruct Money"  data-width="100%" data-height="20" type="checkbox" name="operation">

                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Amount</strong></label>
                                <div class="input-group ">
                                    <input type="text" name="amount" class="form-control form-control-lg" step="0.01">
                                    <div class="input-group-append"><span class="input-group-text">{{$basic->currency}}</span></div>
                                </div>
                                @if ($errors->has('amount'))
                                    <span class="help-block" style="color: red">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 ">
                                <label> <strong>Message</strong></label>
                                <textarea name="message"  class="form-control form-control-lg"  rows="5" placeholder="Write Message.." required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="tile">
                <h4 class="tile-title">
                    <i class="fa fa-user"></i> User Profile
                </h4>
                <div class="title-body">
                        @if( file_exists($user->image))
                            <img src=" {{url('assets/user/images/'.$user->image)}} " class="img-responsive propic"
                                 alt="Profile Pic">
                        @else

                            <img src=" {{url('assets/user/images/user-default.png')}} " class="img-responsive propic"
                                 alt="Profile Pic">
                        @endif

                        <br>
                    <h5 class="padding-left-10">Username : {{ $user->username }}</h5>
                    <h5 class="padding-left-10">Name : {{$user->fname }} {{$user->lname }}</h5>
                    <h6 class="padding-left-10">BALANCE : {{number_format(floatval($user->balance), $basic->decimal, '.', '')}} {{$basic->currency}}</h6>
                    <hr>
                    <p class="padding-left-10"><strong>Last Login : {{ Carbon\Carbon::parse($user->login_time)->diffForHumans() }}</strong> <br></p>
                </div>
            </div>

        </div>


    </div>


@endsection


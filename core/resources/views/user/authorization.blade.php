@extends('layout')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/front/css/form.css')}}">
@stop
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1 class="plus-margin">{{$page_title}}</h1>
            </div>
        </div>
    </div>


    @if(Auth::user()->status == 0)
        <section class="login-page-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="title text-danger"> Your Account Has been Blocked</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else

        @if(Auth::user()->email_verify == 0 && Auth::user()->phone_verify == 0)

            <section class="login-page-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="section-title">
                                <h2 class="title">Email Verification</h2>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="login-form-wrapper">
                                @include('errors.alert')


                                <form  action="{{route('user.send-emailVcode') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                    <p>Your E-mail :<strong> {{Auth::user()->email}}</strong></p>
                                    <div class=" margin-bottom-20 ">
                                            <input type="submit" class="submit-btn btn btn-block" value="Send Code">
                                    </div>
                                </form>


                                <div class="margin-top-20"></div>

                                <form  action="{{ route('user.email-verify')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">

                                    <div class="form-element has-icon margin-bottom-20">
                                        <input name="email_code" type="text"
                                               placeholder="Enter  Code"
                                               class="input-field" required autofocus>
                                        @if ($errors->has('email_code'))
                                            <span class="error ">
                                                <strong>{{ $errors->first('email_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class=" margin-bottom-20 ">
                                        <input type="submit" class="submit-btn btn btn-block" value="Submit">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @elseif(Auth::user()->email_verify == 0)

            <section class="login-page-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="section-title">
                                <h2 class="title">Email Verification</h2>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="login-form-wrapper">
                                @include('errors.alert')


                                <form  method="post" action="{{route('user.send-emailVcode') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                    <p>Your E-mail :<strong> {{Auth::user()->email}}</strong></p>
                                    <div class=" margin-bottom-20 ">
                                        <input type="submit" class="submit-btn btn btn-block" value="Send Code">
                                    </div>
                                </form>


                                <div class="margin-top-20"></div>

                                <form  action="{{ route('user.email-verify')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">

                                    <div class="form-element has-icon margin-bottom-20">
                                        <input name="email_code" type="text"
                                               placeholder="Enter  Code"
                                               class="input-field" required autofocus>
                                        @if ($errors->has('email_code'))
                                            <span class="error ">
                                                <strong>{{ $errors->first('email_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class=" margin-bottom-20 ">
                                        <input type="submit" class="submit-btn btn btn-block" value="Submit">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @elseif(Auth::user()->phone_verify == 0)
            <section class="login-page-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="section-title">
                                <h2 class="title">Phone Verification</h2>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="login-form-wrapper">
                                @include('errors.alert')


                                <form  method="post" action="{{route('user.send-vcode') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                    <p>Your Mobile No:<strong> {{Auth::user()->phone}}</strong></p>
                                    <div class=" margin-bottom-20 ">
                                        <input type="submit" class="submit-btn btn btn-block" value="Send Code">
                                    </div>
                                </form>


                                <div class="margin-top-20"></div>

                                <form  method="post" action="{{ route('user.sms-verify')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">

                                    <div class="form-element has-icon margin-bottom-20">
                                        <input name="sms_code" type="text"
                                               placeholder="Enter  Code"
                                               class="input-field" required autofocus>
                                        @if ($errors->has('sms_code'))
                                            <span class="error ">
                                                <strong>{{ $errors->first('sms_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class=" margin-bottom-20 ">
                                        <input type="submit" class="submit-btn btn btn-block" value="Submit">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @else
            @php return redirect('user/home') @endphp

        @endif


    @endif


@endsection

@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/front/css/form.css')}}">
@stop
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>


    <!-- login page content area start -->
    <section class="login-page-area">
        <div class="container">
            @if($basic->registration == 0)
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="title"> {{$page_title}} Has been Deactivated By Admin</h2>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title">
                            <h2 class="title">Create An Account</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="login-form-wrapper">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                @if(isset($reference))
                                    <input type="hidden" name="referBy"  value="{{$reference}}">
                                @endif
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-element margin-bottom-20">
                                            <input type="text" name="fname" value="{{ old('fname') }}"
                                                   class="input-field" placeholder="First Name">
                                            @if ($errors->has('fname'))
                                                <span class="error ">{{ $errors->first('fname') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-element margin-bottom-20">
                                            <input type="text" name="lname" value="{{ old('lname') }}"
                                                   class="input-field" placeholder="Last Name">
                                            @if ($errors->has('lname'))
                                                <span class="error ">{{ $errors->first('lname') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-element margin-bottom-20">
                                            <input type="text" name="username" value="{{ old('username') }}"
                                                   class="input-field" placeholder="Username">
                                            @if ($errors->has('username'))
                                                <span class="error">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-element margin-bottom-20">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                   class="input-field" placeholder="Contact Number">
                                            @if ($errors->has('phone'))
                                                <span class="error">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-element margin-bottom-20">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                   class="input-field" placeholder="Email Address">
                                            @if ($errors->has('email'))
                                                <span class="error ">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-element margin-bottom-20">
                                            <input type="password" name="password" class="input-field"
                                                   placeholder="Password">
                                            @if ($errors->has('password'))
                                                <span class="error ">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-element margin-bottom-20">
                                            <input type="password" name="password_confirmation" class="input-field"
                                                   placeholder="Confirm Password">
                                        </div>
                                    </div>


                                    <div class="col-lg-12">

                                        <div class="btn-wrapper">
                                            <div class="left-content">
                                                <input type="submit" class="submit-btn" value="Regsiter">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="from-footer">
                                    <span class="ftext">Already have an account?  <a
                                            href="{{ route('login') }}">Sign In</a></span>
                                </div>

                            </form>
                        </div><!-- //. login form wrapper -->
                    </div>
                </div>

            @endif
        </div>
    </section>
    <!-- login page content area end -->

@endsection

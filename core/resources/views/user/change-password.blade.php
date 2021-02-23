@extends('user')

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

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-form-wrapper">
                        @include('errors.alert')

                        <form action="" method="post" role="form">
                            @csrf
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <input type="password" name="current_password"  class="input-field" placeholder="Current Password">
                                        @if ($errors->has('current_password'))
                                            <span class="error">{{ $errors->first('current_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <input type="password" name="password"  class="input-field" placeholder="New Password">
                                        @if ($errors->has('password'))
                                            <span class="error">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <input type="password" name="password_confirmation"  class="input-field" placeholder="Confirm Password">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="error">
                                                {{ $errors->first('password_confirmation') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="btn-wrapper">
                                        <input type="submit" class="submit-btn btn-block" value=" Change Password">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div><!-- //. login form wrapper -->
                </div>
            </div>
        </div>
    </section>
    <!-- login page content area end -->






@endsection

@section('script')
@endsection

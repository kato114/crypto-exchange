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



    <!-- login page content area start -->
    <section class="login-page-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="title">Forget Password</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-form-wrapper">


                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if(Session::has('danger'))
                            <div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('danger') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="Email Address">
                                        @if ($errors->has('email'))
                                            <span class="error ">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <div class="btn-wrapper">
                                            <input type="submit" class="submit-btn btn-block" value="Send Reset Link">
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

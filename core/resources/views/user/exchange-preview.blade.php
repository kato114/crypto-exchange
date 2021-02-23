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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="title">Confirm Exchange </h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-form-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Please Sent <span class="base-color">{{$exchange->from_amount}} {{$exchange->fromCurrency->symbol}}</span> this Payment ID  </h6>
                                <h6> Payment ID : <span class="base-color">{{$exchange->fromCurrency->payment_id}}</span></h6>
                            </div>
                            <div class="col-lg-5 offset-md-1">
                                <h6> Name: <span class="padding-left-10">{{$exchange->user->fname}} {{$exchange->user->lname}}</span></h6>
                                <h6> Email: <span class="padding-left-10">{{$exchange->user->email}} </span></h6>
                                <h6> phone: <span class="padding-left-10">{{$exchange->user->phone}} </span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-form-wrapper">
                        <form method="POST" action="{{route('exchange.confirmed')}}" enctype="multipart/form-data">
                            <input type="hidden" name="trx" value="{{$exchange->trx}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="form-element margin-bottom-20 has-icon">
                                        <label for="">You will pay {{$exchange->fromCurrency->name}} </label>
                                        <input type="text" name="enter_amount" value="{{$exchange->from_amount}}"
                                               class="input-field" placeholder="Your Amount " readonly>
                                        <div class="the-icon ">{{$exchange->fromCurrency->symbol}}</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-element margin-bottom-20 has-icon">
                                        <label for="">You will be Get {{$exchange->toCurrency->name}} </label>
                                        <input type="text" name="get_amount" value="{{$exchange->receive_amount}}"
                                               class="input-field" placeholder="You Need " readonly>
                                        <div class="the-icon ">{{$exchange->toCurrency->symbol}}</div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Transaction Number <span class="error">*</span> </label>
                                        <input type="text" name="transaction_number" value="{{ old('transaction_number') }}"
                                               class="input-field" placeholder="Transaction Number">
                                        @if ($errors->has('transaction_number'))
                                            <span class="error ">{{ $errors->first('transaction_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Transaction ScreenShoot <span class="error">*</span> </label>
                                        <input type="file" name="image"class="input-field" >
                                        @if ($errors->has('image'))
                                            <span class="error ">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Enter Your {{$exchange->toCurrency->name}} Account  <span class="error">*</span> </label>
                                        <input type="text" name="user_payment_id" value="{{ old('user_payment_id') }}"
                                               class="input-field" placeholder="{{$exchange->toCurrency->name}} Account">
                                        @if ($errors->has('user_payment_id'))
                                            <span class="error ">{{ $errors->first('user_payment_id') }}</span>
                                        @endif
                                    </div>
                                </div>




                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label for="">Additional Information (Optional) </label>
                                        <textarea name="info" class="input-field form-control" rows="8"
                                                  placeholder="Say something ...">{{old('info')}}</textarea>

                                        @if ($errors->has('info'))
                                            <span class="error ">{{ $errors->first('info') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <button type="submit" class=" custom-button btn btn-block">Confirm to Exchange</button>
                                </div>
                            </div>


                        </form>
                    </div><!-- //. login form wrapper -->
                </div>
            </div>


        </div>
    </section>
    <!-- login page content area end -->




@stop

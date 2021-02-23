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
                        <h2 class="title">Make Payment </h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-form-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Please Sent <span class="base-color">{{$buy->enter_amount}} {{$buy->currency->symbol}}</span> this Payment ID  </h6>
                                <h6> Payment ID : <span class="base-color">{{$buy->currency->payment_id}}</span></h6>
                            </div>
                            <div class="col-lg-5 offset-lg-1">
                                <h6> Name: <span>{{$buy->user->fname}} {{$buy->user->lname}}</span></h6>
                                <h6> Email: <span>{{$buy->user->email}} </span></h6>
                                <h6> phone: <span>{{$buy->user->phone}} </span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-form-wrapper">
                        <form method="POST" action="{{route('sell.confirmed.bank')}}" enctype="multipart/form-data">
                            <input type="hidden" name="trx" value="{{$buy->trx}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="form-element margin-bottom-20 has-icon">
                                        <label for="">You will Pay  {{$buy->currency->name}}</label>
                                        <input type="text" name="enter_amount" value="{{$buy->enter_amount}}"
                                               class="input-field" placeholder="Your Amount " readonly>
                                        <div class="the-icon ">{{$buy->currency->symbol}}</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-element margin-bottom-20 has-icon">
                                        <label for=""> You will be Get  </label>
                                        <input type="text" name="get_amount" value="{{$buy->get_amount}}"
                                               class="input-field" placeholder="You Need " readonly>
                                        <div class="the-icon ">{{$basic->currency}}</div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Transaction No. <span class="error">*</span> </label>
                                        <input type="text" name="account" value="{{ old('account') }}"
                                               class="input-field" placeholder="Transction Number">
                                        @if ($errors->has('account'))
                                            <span class="error ">{{ $errors->first('account') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Transaction screenshot <span class="error">*</span> </label>
                                        <input type="file" name="image" class="input-field">
                                        @if ($errors->has('image'))
                                            <span class="error ">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-element margin-bottom-20">
                                        <label>Payment Method <span class="error">*</span> </label>
                                        <textarea name="info" class="input-field form-control" rows="8"
                                                  placeholder="Send your account details  ...">{{old('info')}}</textarea>

                                        @if ($errors->has('info'))
                                            <span class="error ">{{ $errors->first('info') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class=" custom-button btn btn-block">Confirm Order</button>
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

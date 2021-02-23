@extends('user')
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>


    <div class="term-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="terms text-center">
                        <h6 class="text-color"> PLEASE SEND EXACTLY <span style="color: green"> {{ $bcoin }}</span> ETH</h6>
                        <h5>TO <span style="color: green"> {{ $wallet}}</span></h5>
                        {!! $qrurl !!}
                        <h4 class="text-color">SCAN TO SEND</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

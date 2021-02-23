@extends('layout')

@section('css')
@endsection
@section('content')


    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}} </h1>
            </div>
        </div>
    </div>
    <div class="term-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="terms">
                        <p>{!! $basic->terms !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
@endsection

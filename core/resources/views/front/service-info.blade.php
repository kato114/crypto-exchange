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



    <div class="faq-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2 class="plus-margin">{{$basic->service_heading}}</h2>
                        <p>{{$basic->service_para}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">

                <div class="row">
                        <div class="filtr-item  col-md-12">
                            <div class="single-faq">
                                <h3><span class="a-circle">{!! $data->icon !!}</span> {{$data->title}}</h3>
                                <p> {!! $data->details !!}</p>
                            </div>
                        </div>
                </div>
        </div>
    </div>



@endsection
@section('js')
@endsection

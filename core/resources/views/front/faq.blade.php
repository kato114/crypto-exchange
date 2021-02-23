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
                        <h2 class="plus-margin">Frequently Asked Questions</h2>
                        <p>Hopefully we can answer your questions.

                            If you have any additional questions about <strong>{{$basic->sitename}}</strong>, Please
                            send us a
                            <a href="{{route('contact-us')}}"><strong>message</strong></a> any time .</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">

            @foreach($faqs->chunk(3) as $faq)
                <div class="row">

                    @foreach($faq as $k =>$data)
                        <div class="filtr-item  col-md-12">
                            <div class="single-faq">
                                <h3><span class="a-circle">{{sprintf('%02d', ++$k)}}</span> {{$data->title}}</h3>
                                <p> {!! $data->description !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>



@endsection
@section('js')
@endsection

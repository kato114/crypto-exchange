@extends('layout')

@section('css')
@endsection
@section('content')





    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>


    <div class="contact-area">
        <div class="container maps-style">
            <div class="row d-flex">
                <div class="col-xl-5 col-lg-6">
                    <div class="address-bar">
                        <h3>Let’s Get<br/> In Touch Here</h3>

                        @php
                            $email = array_filter(explode(' ',str_replace(',',' ',$basic->email)));
                            $phones = array_filter(explode(' ',str_replace(',',' ',$basic->phone)));
                        @endphp

                        <p><span><i class="fas fa-map-marker-alt"></i></span>
                           {!! $basic->address !!}</p>

                        <p><span><i class="far fa-envelope"></i></span>
                            @foreach($email as $test){{$test}} <br>@endforeach
                        </p>
                        <p><span><i class="fas fa-phone"></i></span>
                            @foreach($phones as $test) {{$test}} <br> @endforeach
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 d-flex align-items-center shadows col-lg-6">
                    <div class="form-bar">
                        <h3>What Is Your Mind <br/>Tell Here</h3>
                        @include('errors.error')
                        @include('errors.alert')
                        <form action="" method="post" >
                        @csrf


                            <input type="text" name="name" placeholder="Your Name">

                            <input type="text" name="phone" placeholder="Contact Number ">

                            <input type="email" name="email" placeholder="Email Address">
                            <input type="text" name="subject" placeholder="Subject">

                            <textarea name="message" placeholder="Your Message"></textarea>
                            <button type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key={{$basic->map_api}}&callback=initMap"
            async defer></script>
    <!-- google map activate js -->
    <script src="{{asset('assets/front/js/google-map-activate.js')}}"></script>

@endsection

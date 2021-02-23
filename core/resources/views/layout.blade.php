<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{isset($page_title) ? $page_title : ''}} | {{$basic->sitename}} </title>
    <!--Favicon add-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logo/favicon.png')}}">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/select2.min.css')}}">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- icofont css -->
    <link rel="stylesheet" href="{{asset('assets/front/fonts/icofont/icofont.min.css')}}">
    <!-- flaticon css  -->
    <link rel="stylesheet" href="{{asset('assets/front/fonts/flaticon.css')}}">
    <!-- font-awesome -->
    <link rel="stylesheet" href="{{asset('assets/front/css/fontawesome.min.css')}}">
    <!-- owl-carosel -->
    <link rel="stylesheet" href="{{asset('assets/front/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/admin/css/toastr.min.css')}}"/>
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/animate.css')}}">
    <!-- style css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/table.css')}}">
@yield('css')
<!-- responsive css -->

    <link rel="stylesheet" href="{{asset('assets/front/css/color.php')}}?color={{ $basic->color }}">
    <link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">

</head>
<body>

<div class="preloader">
    <div class="loader">Loading...</div>
</div>


<header class="header">
    <div class="container">
        <div class="row d-flex">
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div class="logo">
                    <a href="{{url('/')}}" class="logo main-logo">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="logo" style="max-width: 200px;max-height: 40px;">
                    </a>
                </div>
                <div class="menu-button d-block d-xl-none d-lg-block d-md-block d-sm-block">
                    <i class="icofont-navigation-menu"></i>
                </div>
            </div>
            <div class="col-xl-7 d-flex align-items-center col-lg-8 col-md-12">
                <div class="main-menu">
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{route('blog')}}">News</a></li>
                        <li><a href="#"> Services <span><i class="fas fa-angle-down"></i></span></a>
                            <ul>
                                <li><a href="{{route('exchange')}}">Exchange</a></li>
                                <li><a href="{{route('buy')}}">Buy</a></li>
                                <li><a href="{{route('sell')}}">Sell</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('contact-us')}}">Contact Us</a></li>
                        @if(Auth::user())
                        <li><a href="#">{{Auth::user()->username}} <span><i class="fas fa-angle-down"></i></span></a>
                            <ul>
                                <li><a href="{{route('home')}}">Dashboard</a></li>
                                <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">{{ csrf_field() }}</form>
                            </ul>
                        </li>
                            @endif
                    </ul>
                </div>
            </div>

            @if(Auth::user())
                <div class="col-xl-2 col-lg-2 d-flex align-items-center">
                    <div class="sign-in">
                        <a href="{{route('login')}}">{{number_format(Auth::user()->balance, $basic->decimal)}} {{$basic->currency}}</a>
                    </div>
                </div>
            @else
                <div class="col-xl-2 col-lg-2 d-flex align-items-center">
                    <div class="sign-in">
                        <a href="{{route('login')}}">sign in</a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</header>


@yield('content')


@include('partials.footer')


<!-- jquery js -->
<script src="{{asset('assets/front/js/jquery.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/front/js/select2.min.js')}}"></script>
<script src="{{asset('assets/admin/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
<!-- owl carosel -->
<script src="{{asset('assets/front/js/owl.carousel.js')}}"></script>
<!-- filterizer -->
<script src="{{asset('assets/front/js/jquery.filterizr.min.js')}}"></script>
<!-- wow js -->
<script src="{{asset('assets/front/js/wow.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/front/js/main.js')}}"></script>
@yield('js')
@if (session('success'))
    <script>
        $(document).ready(function () {
            swal("Success!", "{{ session('success') }}", "success");
        });
    </script>
@endif

@if (session('alert'))
    <script>
        $(document).ready(function () {
            swal("Sorry!", "{{ session('alert') }}", "error");
        });
    </script>
@endif

</body>
</html>

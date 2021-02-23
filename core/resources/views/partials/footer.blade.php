<footer class="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3">
                    <div class="single-links">
                        <div class="title">
                            <a href="{{url('/')}}" class="footer-logo">
                                <img src="{{asset('assets/images/logo/logo.png')}}" alt="footer logo" style="width:100%;">
                            </a>
                        </div>
                        <p>{{$basic->copyright}}</p>
                        <div class="social-links">
                            <ul>
                                @foreach($social as $data)
                                    <li><a href="{{$data->link}}">{!! $data->code !!}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3">
                    <div class="single-links">
                        <div class="title">
                            <h3>Company</h3>
                        </div>
                        <div class="links">
                            <ul>

                                <li><a href="{{url('/')}}"><i class="fas fa-caret-right"></i> Home</a></li>
                                <li><a href="{{route('about')}}"><i class="fas fa-caret-right"></i> About Us</a></li>
                                <li><a href="{{route('blog')}}"><i class="fas fa-caret-right"></i> News & Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3">
                    <div class="single-links">
                        <div class="title">
                            <h3>Tools</h3>
                        </div>
                        <div class="links">
                            <ul>
                                @foreach($menus as $data)
                                <li><a href="{{route('menu',[$data->id, str_slug($data->name)])}}"><i class="fas fa-caret-right"></i> {{$data->name}}</a></li>
                                @endforeach
                                <li><a href="{{route('terms-condition')}}"><i class="fas fa-caret-right"></i> Terms & condition</a></li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3">
                    <div class="single-links">
                        <div class="title">
                            <h3>Help & Support</h3>
                        </div>
                        <div class="links">
                            <ul>
                                <li><a href="{{route('faqs')}}"><i class="fas fa-caret-right"></i> FAQ</a></li>
                                <li><a href="{{route('contact-us')}}"><i class="fas fa-caret-right"></i> Contact Us</a></li>
                                <li><a href="{{route('privacy-policy')}}"><i class="fas fa-caret-right"></i> Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">
                    <div class="copyright">
                        <p class="text-center">{{$basic->sitename}} © {{date('Y')}}. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

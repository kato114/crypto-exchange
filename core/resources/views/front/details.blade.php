@extends('layout')

@section('css')

@endsection
@section('content')
    {!! $basic->fb_comment !!}



    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>Blog Details </h1>
            </div>
        </div>
    </div>


    <div class="blog-area blog-feed-area">
        <div class="container">
            <div class="row">

                <div class="col-xl-8 col-sm-12 col-lg-8">
                    <div class="blog-left-side">
                        <div class="blog-details">
                            <img src="{{asset('assets/images/post/'.$post->image)}}" alt="image">

                            <h2>{{$post->title}}</h2>
                            <p> {!! $post->details !!}</p>
                        </div>

                        <div class="tags-nd-share">
                            <div class="part-share">
                                <h4>Social Share</h4>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a>
                                <a href="https://plus.google.com/share?url={{urlencode(url()->current()) }}"><i class="fab fa-google-plus-g"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary"><i class="fab fa-linkedin-in"></i></a>
                            </div>

                            <div class="part-tag">
                                <br><br>
                            </div>
                        </div>

                        <div class="comments">
                            <div class="fb-comments" data-colorscheme="dark" data-width="100%"
                                 data-href="{{url()->current()}}"
                                 data-numposts="5"></div>
                        </div>

                    </div>
                </div>



                <div class="col-xl-4 col-sm-12 col-lg-4">
                    <div class="blog-right-side">

                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-md-6 col-lg-12">
                                @include('partials.follow-us')

                                @include('partials.category-list')
                            </div>

                           @include('partials.latest-blog')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
@endsection

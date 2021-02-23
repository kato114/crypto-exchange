@extends('layout')

@section('css')
<style>
    .blog-area {
        padding-top: 60px!important;
    }
    .btn-filter {
        margin: 4px;
    }

    .btn-outline-primary {
        box-shadow: none!important;
    }

    .search-container {
        margin-bottom: 20px!important;
    }
</style>
@endsection
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>
    <div class="blog-area">
        <div class="container search-container">
            <div class="row">
                <div class="col-lg-12 mt-4">
                    <h3>Search</h3>
                </div>
                <div class="col-lg-12">
                    <div class="input-group has-success mb-3">
                        <input id="inp_search" type="text" class="form-control form-control-primary" placeholder="Input keyword." aria-label="Input keywork!" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="btn_search_run" class="btn btn-outline-primary" type="button">Search</button>
                            <button id="btn_search_advance" class="btn btn-outline-primary" type="button"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="search-option" class="d-none">
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <h3>Category</h3>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-outline-primary btn-filter btn-filter-category active" value="/category?section=general">The General News</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-category" value="?tickers=BTC,ETH,XRP">The Ticket News</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <h3>Topic</h3>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Digital+Dollar">The Digital Dollar</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Digital+Euro">The Digital Euro</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Futures">Futures contracts</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Mining">Mining crypto</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Stablecoins">Stablecoins</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Tanalysis">Technical Analysiss</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Taxes">IRS and Taxes</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Upgrade">Upgrades and Hard Forks</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-topic" value="Whales">Whales Buying and Selling</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <h3>Sentiment</h3>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-outline-primary btn-filter btn-filter-sentiment" value="neutral">Neutral</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-sentiment" value="positive">Positive</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-sentiment" value="negative">Negative</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <h3>Date</h3>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last5min">Last 5min</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last10min">Last 10min</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last15min">Last 15min</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last30min">Last 30min</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last45min">Last 45min</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last60min">Last 60min</button>
                        <br>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="today">Today</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="yesterday">Yesterday</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last7days">Last 7days</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last30days">Last 30days</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last60days">Last 60days</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="last90days">Last 90days</button>
                        <button class="btn btn-outline-primary btn-filter btn-filter-date" value="yeartodate">Year to Date</button>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-lg-12">
                    <div class="blog-left-side">
                        <div id="blog-list"></div>
                        <div id="blog-loading-spinner" class="text-center d-none">
                            <img src="{{ asset('assets/images/spinner-loading.gif') }}" alt="" width="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('js')
    <script>
        let loading_status = false

        let param_category = null
        let param_topic = null
        let param_search = null
        let param_sentiment = null
        let param_date = null
        let param_page = null

        $("#btn_search_advance").on('click', function() {
            $(this).find('i').toggleClass('fa-angle-down')
            $(this).find('i').toggleClass('fa-angle-up')

            $("#search-option").toggleClass('d-none')
        })

        $("#btn_search_run").on('click', function() {
            $("#search-option").addClass('d-none')

            initParams()
            loadNews()
        })

        $("#inp_search").on('keypress', function(event) {
            if(event.keyCode == 13) {
                initParams()
                loadNews()
            }
        })

        $(".btn-filter-category").on('click', function() {
            $(".btn-filter-category").removeClass('active')
            $(this).addClass('active')
        })

        $(".btn-filter-topic").on('click', function() {
            $(this).toggleClass('active')
        })

        $(".btn-filter-sentiment").on('click', function() {
            if($(this).hasClass('active')) {
                $(".btn-filter-sentiment").removeClass('active')
            } else {
                $(".btn-filter-sentiment").removeClass('active')
                $(this).toggleClass('active')
            }
        })

        $(".btn-filter-date").on('click', function() {
            if($(this).hasClass('active')) {
                $(".btn-filter-date").removeClass('active')
            } else {
                $(".btn-filter-date").removeClass('active')
                $(this).toggleClass('active')
            }
        })

        window.addEventListener("scroll", function() {
            if($(".single-blog:last").get(0) != undefined) {
                const triggerBottom = window.innerHeight
                const blogBottom = $(".single-blog:last").get(0).getBoundingClientRect().bottom

                if(triggerBottom < blogBottom + 100)
                    return
            }

            loadNews()
        })

        var loadNews = function() {
            if(loading_status) return
            if(param_page == 1) $("#blog-list").empty()

            loading_status = true

            $("#blog-loading-spinner").toggleClass('d-none')

            $.ajax({
                method: "POST",
                url: "{{ route('blog.data') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category: param_category,
                    topic: param_topic,
                    search: param_search,
                    sentiment: param_sentiment,
                    date: param_date,
                    page: param_page,
                }
            })
            .done(function( msg ) {
                var result = JSON.parse(msg)

                if(result["errors"] === undefined) {
                    for(var i = 0; i < result["data"].length; i++) {
                        var data = result["data"][i]

                        console.log(data)

                        $("#blog-list").append('\
                            <div class="single-blog">\
                                <div class="row">\
                                    <div class="col-md-4">\
                                        <div class="part-img"> <img src="' + data.image_url + '" alt=""> </div>\
                                    </div>\
                                    <div class="col-md-8">\
                                        <i class="far fa-clock"> ' + data.date + '</i>\
                                        <h4><a class="no-text-decoration" href="' + data.news_url + '" target="_blank">' + data.title + '</a></h4>\
                                        <p>' + data.text + '</p>\
                                    </div>\
                                </div>\
                            </div>')
                    }

                    param_page++
                    loading_status = false

                    $("#blog-loading-spinner").toggleClass('d-none')
                }
            })
        }

        var initParams = function() {
            param_page = 1
            param_category = $(".btn-filter-category.active").get(0) == undefined ? null : $($(".btn-filter-category.active").get(0)).val()
            param_sentiment = $(".btn-filter-sentiment.active").get(0) == undefined ? null : $($(".btn-filter-sentiment.active").get(0)).val()
            param_date = $(".btn-filter-date.active").get(0) == undefined ? null : $($(".btn-filter-date.active").get(0)).val()
            param_topic = ''
            param_search = $("#inp_search").val().length == 0 ? null : $("#inp_search").val()

            if($(".btn-filter-topic.active").length > 0) {
                for(var i = 0; i < $(".btn-filter-topic.active").length; i++)
                    param_topic = param_topic + $($(".btn-filter-topic.active")[i]).val() + ","
            } else {
                param_topic = null
            }

            console.log("1111111")
        }

        $(document).ready(function() {
            initParams()
            loadNews()
        })
    </script>
@endsection

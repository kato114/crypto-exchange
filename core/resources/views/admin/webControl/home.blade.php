@extends('admin')
@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        rect{
            fill: #8e44ad;
        }
    </style>
@endsection
@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Questions LIST</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body text-center">
                    @php
                        $totalusers = \App\User::where('status',1)->count();
                        $banusers = \App\User::where('status',0)->count();
                        $sell = \App\Sell::where('status',0)->sum('id');
                    @endphp

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$totalusers}}">{{$totalusers}}</span>
                                    </div>
                                    <div class="desc"> Total User </div>
                                </div>
                                <a class="more" href="{{route('users')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$banusers}}">{{$banusers}}</span>
                                    </div>
                                    <div class="desc"> Banned Users </div>
                                </div>
                                <a class="more" href="{{route('users')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$sell}}">{{$sell}}</span>
                                    </div>
                                    <div class="desc"> Total Sell </div>
                                </div>
                                <a class="more" href="{{route('sellLog')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                    </div>


                    @php
                        $main_chart_data = "[";
                        $trans = \App\Product::latest()->take(50)->get();
                            foreach ($trans as $data){
                             $main_chart_data .= "{ year: '".date('Y-m-d', strtotime($data->created_at))."' , value:  ".$data->sells()->count()."  }".",";
                            }
                        $main_chart_data .= "]";

                    @endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div id="mychart" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




@endsection


@section('import-script')

    <!-- START PAGE LEVEL PLUGINS -->
    <script src="{{asset('assets/admin/')}}/js/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="{{asset('assets/admin/')}}/js/jquery.counterup.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

@stop
@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        $(document).ready(function () {
            new Morris.Bar({
                element: 'mychart',
                data: @php echo $main_chart_data  @endphp,
                xkey: 'year',
                ykeys: ['value'],
                // chart.
                labels: ['Value']
            });
        });
    </script>
@endsection





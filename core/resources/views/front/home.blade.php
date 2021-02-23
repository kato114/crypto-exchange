@extends('layout')

@section('css')
@endsection
@section('content')
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="banner-content">
                        <h1>{{$basic->section1_heading}}</h1>
                        <p>{{$basic->section1_para}}</p>
                    </div>

                    <div class="exchange-now">
                        <a href="{{route('register')}}">
                            <button class="exchange-now-button">Join Us</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="service-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2>{{$basic->service_heading}}</h2>
                        <p>{{$basic->service_para}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach($service as $data)
                    <div class="col-xl-4 col-lg-4 col-sm-12 col-md-6">
                        <div class="single-service">
                            <div class="part-icon">
                                {!! $data->icon !!}
                            </div>
                            <div class="part-text">
                                <h3>{{$data->title}}</h3>
                                <p>{{str_limit($data->details,90)}}</p>
                                <a href="{{route('serve',[$data->id, str_slug($data->title)])}}">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <div class="payout-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2 class="plus-margin">{{$basic->payout_title}}</h2>
                        <p>{{$basic->payout_details}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Exchange <br> <br/></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sell  <br><br/></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Buy  <br><br/></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="chart">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Exchanger Name	</th>
                                        <th scope="col"> Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exchange as $data)
                                    <tr>
                                        <th scope="row"><i class="fas fa-calendar-alt"></i> {{date('d F Y', strtotime($data->created_at))}}</th>
                                        <td> {{$data->toCurrency->name}}</td>
                                        <td>{{$data->user->fname}} {{$data->user->lname}}</td>
                                        <td><i class="icofont-money"></i> {{$data->receive_amount}} <span>{{$data->toCurrency->symbol}}</span></td>

                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="chart">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Seller Name	</th>
                                        <th scope="col"> Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sellMoney as $data)
                                    <tr>
                                        <th scope="row"><i class="fas fa-calendar-alt"></i> {{date('d F Y', strtotime($data->created_at))}}</th>
                                        <td>{{$data->currency->name}}</td>
                                        <td>{{$data->user->fname}} {{$data->user->lname}}</td>
                                        <td><i class="icofont-money"></i> {{$data->enter_amount}} <span>{{$data->currency->symbol}}</span></td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="chart">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Buyer Name	</th>
                                        <th scope="col"> Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($buyMoney as $data)
                                    <tr>
                                        <th scope="row"><i class="fas fa-calendar-alt"></i> {{date('d F Y', strtotime($data->created_at))}}</th>
                                        <td>{{$data->currency->name}}</td>
                                        <td>{{$data->user->fname}} {{$data->user->lname}}</td>
                                        <td><i class="icofont-money"></i> {{$data->get_amount}} <span>{{$data->currency->symbol}}</span></td>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <div class="signup-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2>Subscribe For More Updates</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-around d-flex">
                <div class="col-md-8">
                    <div class="form">
                        <form class="signup-form" action="{{route('subscribe')}}" method="post">
                            @csrf
                            <div class="mail-area">
                                <p class="text-center">Please Subscribe & Get Updates</p>
                                <input type="email" name="email" placeholder="Enter your email here..." required>
                                <i class="icofont-email"></i>
                            </div>
                            <button type="submit" class="submit-button">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="client-comments">

        <div class="container">
            <div class="row justify-content-xl-between justify-content-sm-center">
                <div class="col-lg-12">
                    <div class="all-comments">
                        @foreach($testimonial as $data)
                        <div class="single-comment">
                            <div class="part-img">
                                <img src="{{asset('assets/images/testimonial/'.$data->image)}}" alt="..." class="rounded-circle">
                            </div>
                            <div class="part-text">
                                <h3>{{$data->name}}</h3>
                                <h4>{{$data->designation}}</h4>
                                <p>{!! $data->details !!}</p>
                            </div>
                        </div>
                            @endforeach

                    </div>
                </div>



            </div>
        </div>
    </div>



@endsection
@section('js')

    <script>
        $(document).ready(function () {
            var from_amount = $(".from_amount").val();
            var receive_amount = $(".receive_amount").val();

            $(".from_amount, #from_currency_id, .receive_amount, #receive_currency_id ").on('keyup change', function () {

                var enterAmount = $(".from_amount").val();
                var fromAmountPrice = $("#from_currency_id option:selected").data('price');
                var fromAmountExchangeCharge = $("#from_currency_id option:selected").data('exchange');

                var receiveAmountPrice = $("#receive_currency_id option:selected").data('price');
                var receiveAmountExchangeCharge = $("#receive_currency_id option:selected").data('exchange');


                var getAmountTotal = parseFloat((receiveAmountPrice/ fromAmountPrice)*enterAmount);
                var chargeFromTotalAmoFromEnter = parseFloat((getAmountTotal*receiveAmountExchangeCharge)/100);
                var getAmountInput = parseFloat((getAmountTotal - chargeFromTotalAmoFromEnter));
                $(".receive_amount").val(getAmountInput.toFixed(8));
            });

        });
    </script>
@endsection

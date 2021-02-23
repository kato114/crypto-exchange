@extends('user')
@section('content')
    <style>
        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }
    </style>
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>



    <div class="term-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-12 col-md-12">
                    @include('errors.alert')
                </div>

                <div class="col-xl-10">
                    <div class="terms">
                        <h2 class="text-center">Stripe Payment</h2>
                        <div class="card-wrapper"></div>
                        <br><br>

                        <form role="form" id="payment-form" method="POST" action="{{ route('ipn.stripe')}}">
                            {{csrf_field()}}
                            <input type="hidden" value="{{ $track }}" name="track">
                            <div class="row">
                                <div class="col-md-6">


                                    <label for="name"><strong>CARD NAME</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" name="name" placeholder="Card Name" autocomplete="off" autofocus/>
                                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default">
                                                    <i class="fa fa-font"></i>
                                                </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="cardNumber"><strong>CARD NUMBER</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="off"
                                               required autofocus/>
                                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default">
                                                    <i class="fa fa-credit-card"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cardExpiry"><strong>EXPIRATION DATE</strong></label>
                                    <input
                                        type="tel"
                                        class="form-control form-control-lg"
                                        name="cardExpiry"
                                        placeholder="MM / YYYY"
                                        autocomplete="off"
                                        required
                                    />
                                </div>
                                <div class="col-md-6 pull-right">

                                    <label for="cardCVC"><strong>CVC CODE</strong></label>
                                    <input
                                        type="tel"
                                        class="form-control form-control-lg"
                                        name="cardCVC"
                                        placeholder="CVC"
                                        autocomplete="off"
                                        required
                                    />

                                </div>
                            </div>
                            <br>
                            <div class="btn-wrapper">
                                <input class="submit-btn btn-block" type="submit" value="PAY NOW">

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@stop

@section('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@stop



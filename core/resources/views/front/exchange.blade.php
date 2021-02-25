@extends('layout')

@section('css')
<style>
    .site-logo {
        width: 100%;
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

    <div class="processing-area confirmation-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="part-content">
                        <h2>Check The Exchange Balance & Have A Look At The Transfer Details</h2>
                    </div>
                </div>
                <div class="col-xl-6">
                    <form action="{{route('exchange.amount')}}" method="post">
                        @csrf
                        <div class="banner-content">
                            @include('errors.error')

                            <div class="exchange-button">
                                <input type="text" name="from_amount" class="from_amount" placeholder="0.00"
                                        autocomplete="off"
                                        onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                <select name="from_currency_id" id="from_currency_id">
                                    @foreach($currency as $data)
                                        <option value="{{$data->id}}"
                                                data-id="{{$data->id}}"
                                                data-name="{{$data->name}}"
                                                data-symbol="{{$data->symbol}}"
                                                data-price="{{$data->price}}"
                                                data-available="{{$data->available_balance}}"
                                                data-exchange="{{$data->exchange}}"
                                                data-sell="{{$data->sell}}"
                                                data-buy="{{$data->buy}}"
                                                data-paymentId="{{$data->payment_id}}"
                                        >{{$data->symbol}}</option>
                                    @endforeach
                                </select>
                                <div class="icon">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="exchange-button">
                                <input type="text" name="receive_amount" class="receive_amount" readonly
                                        placeholder="0.00" autocomplete="off"
                                        onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                <select name="receive_currency_id" id="receive_currency_id">
                                    @foreach($currency2 as $data)
                                        <option value="{{$data->id}}"
                                                data-id="{{$data->id}}"
                                                data-name="{{$data->name}}"
                                                data-symbol="{{$data->symbol}}"
                                                data-price="{{$data->price}}"
                                                data-available="{{$data->available_balance}}"
                                                data-exchange="{{$data->exchange}}"
                                                data-sell="{{$data->sell}}"
                                                data-buy="{{$data->buy}}"
                                                data-paymentId="{{$data->payment_id}}">{{$data->symbol}}</option>
                                    @endforeach
                                </select>
                                <div class="icon">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="exchange-now">
                            <button type="submit" class="exchange-now-button">Exchange Now</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center">Other Exchange Websites</h4>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.binance.com/en?ref=1016259">
                        <img class="site-logo" src="{{asset('assets/images/others/binance.png')}}" alt="">
                        <p class="text-center">https://www.binance.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.kucoin.com/">
                        <img class="site-logo" src="{{asset('assets/images/others/bitforex.png')}}" alt="">
                        <p class="text-center">https://www.kucoin.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.coinbase.com/">
                        <img class="site-logo" src="{{asset('assets/images/others/bittrex.png')}}" alt="">
                        <p class="text-center">https://www.coinbase.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://hitbtc.com/btc-to-usdt">
                        <img class="site-logo" src="{{asset('assets/images/others/coinbase.png')}}" alt="">
                        <p class="text-center">https://www.hitbtc.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.gate.io/">
                        <img class="site-logo" src="{{asset('assets/images/others/coinbase_pro.png')}}" alt="">
                        <p class="text-center">https://www.gate.io</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://pro.coinbase.com/">
                        <img class="site-logo" src="{{asset('assets/images/others/gate.png')}}" alt="">
                        <p class="text-center">https://pro.coinbase.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.kraken.com/en-us/">
                        <img class="site-logo" src="{{asset('assets/images/others/gemni.png')}}" alt="">
                        <p class="text-center">https://www.kraken.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.gemini.com/">
                        <img class="site-logo" src="{{asset('assets/images/others/hitbtc.png')}}" alt="">
                        <p class="text-center">https://www.gemini.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.mxc.co/">
                        <img class="site-logo" src="{{asset('assets/images/others/hotbit.png')}}" alt="">
                        <p class="text-center">https://www.mxc.co</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://bittrex.com/home/markets">
                        <img class="site-logo" src="{{asset('assets/images/others/kraken.png')}}" alt="">
                        <p class="text-center">https://global.bittrex.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.bitforex.com/en/">
                        <img class="site-logo" src="{{asset('assets/images/others/kucoin.png')}}" alt="">
                        <p class="text-center">https://www.bitforex.com</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                    <a class="text-black" target="_blank" href="https://www.hotbit.pro/">
                        <img class="site-logo" src="{{asset('assets/images/others/mxc.png')}}" alt="">
                        <p class="text-center">https://www.hotbit.pro</p>
                    </a>
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

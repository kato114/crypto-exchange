
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


    <div class="processing-area confirmation-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-lg-6">
                            @include('errors.error')
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="exchange-button">
                                <input type="text" name="get_amount" class="get_amount" placeholder=" You will pay"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                       autocomplete="off">
                                <select name="currency_id" class="select_currency" id="buy" required>
                                    @foreach($currency as $data)
                                        <option value="{{$data->id}}" data-id="{{$data->id}}"
                                                data-name="{{$data->name}}" data-price="{{$data->price}}"
                                                data-symbol="{{$data->symbol}}"
                                                data-available="{{$data->available_balance}}"
                                                data-coin="{{$data->is_coin}}" data-exchange="{{$data->exchange}}"
                                                data-sell="{{$data->sell}}" data-buy="{{$data->buy}}"
                                                data-image="{{$data->image}}">
                                            {{$data->symbol}}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="icon">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="exchange-button">
                                <input type="text" name="enter_amount" class="enter_amount"
                                       placeholder="You will Get"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                       autocomplete="off">
                                <span class="custom-round">Amount ({{$basic->currency}})</span>

                            </div>

                                <div class="checkbox-element">
                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-inner error-terms">I've read and agree to the Changely <a
                                                href="{{route('terms-condition')}}"> Terms </a> of Use and <a href="{{route('privacy-policy')}}">Privacy Policy</a>
                                            <input id="tosradio" type="checkbox"  class="check-condition">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                            <button type="submit" class="btn-disable btn btn-default btn-lg custom-button"
                                    onclick="checkradio(event)">Next
                            </button>


                        </div>
                        <div class=" col-lg-6">
                            <div class="part-content">
                                <h2>{{$basic->sell_title}}</h2>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal__" class="modal fade" role="dialog">
        <div class="modal-dialog">


            <form id="redirectForm" class="part-form" action="{{route('sell.amount')}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cash In Select </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="funkyradio">

                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio3" value="pay_wallet"/>
                                <label for="radio3">Cash In my wallet</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio4" value="pay_bank"/>
                                <label for="radio4">Cash In my Bank Account</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="get_amount" class="modal_get_amo">
                        <input type="hidden" name="enter_amount" class="modal_enter_amo">
                        <input type="hidden" name="currency_id" class="modal_select_currency">

                        <button type="submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <div class="payout-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2 class="plus-margin">{{$page_title}} Rate </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div id="home">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Currency</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Sell Charge (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currency as $data)
                                <tr>
                                    <td data-label="Currency">
                                        <img src="{{asset('assets/images/currency/'.$data->image)}}" alt="image"> <span
                                            class="padding-left-20">{{$data->name}}</span></td>
                                    <td data-label="Rate">1 {{$basic->currency}}
                                        = {{$data->price}} {{$data->symbol}}</td>
                                    <td data-label="Sell Charge (%)">{{$data->sell}} %</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.enter_amount, .select_currency').on('keyup change', function () {
                    var selectCurrencyId = $(".select_currency option:selected").data('id');
                    var selectCurrencyPrice = $(".select_currency option:selected").data('price');
                    var selectCurrencySymbol = $(".select_currency option:selected").data('symbol');
                    var selectCurrencyAvailableAmo = $(".select_currency option:selected").data('available');
                    var selectCurrencyBuy = $(".select_currency option:selected").data('sell');

                    var enter_amount = $('.enter_amount').val();
                    $('.available-balance').text(selectCurrencyAvailableAmo)
                    $('.symbol').text(selectCurrencySymbol)

                    var charge = (enter_amount * selectCurrencyBuy) / 100;
                    var chargeFromEnterAmo = (enter_amount - charge);
                    var getAmo = parseFloat(chargeFromEnterAmo * selectCurrencyPrice).toFixed(8);

                    $('.get_amount').val(getAmo);

                    $('.modal_get_amo').val(getAmo)
                    $('.modal_enter_amo').val(enter_amount)
                    $('.modal_select_currency').val(selectCurrencyId)

                });

                $('.get_amount, .select_currency').on('keyup change', function () {
                    var selectCurrencyId = $(".select_currency option:selected").data('id');
                    var selectCurrencyPrice = $(".select_currency option:selected").data('price');
                    var selectCurrencySymbol = $(".select_currency option:selected").data('symbol');
                    var selectCurrencyAvailableAmo = $(".select_currency option:selected").data('available');
                    var selectCurrencyBuy = $(".select_currency option:selected").data('sell');

                    $('.available-balance').text(selectCurrencyAvailableAmo)
                    $('.symbol').text(selectCurrencySymbol)

                    var get_amount = $('.get_amount').val();
                    var enterAmo = parseFloat(get_amount / selectCurrencyPrice);
                    var enterAmoWithCharge = (enterAmo * selectCurrencyBuy) / 100;
                    var payableInUsd = parseFloat(enterAmo + enterAmoWithCharge).toFixed(2);

                    $('.enter_amount').val(payableInUsd);

                    $('.modal_get_amo').val(get_amount)
                    $('.modal_enter_amo').val(payableInUsd)
                    $('.modal_select_currency').val(selectCurrencyId)

                });

                $('#sell, #buy').select2({
                    width: null,
                    theme: 'bootstrap',
                    templateResult: formatState,
                    templateSelection: formatState
                });
            });

            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var image = $(state.element).data('image');
                var $state = $('<span><img src="assets/images/currency/' + image + '" style="width: 30px;height: 20px;margin-right: 5px;">' + state.text + '</span>');
                return $state;
            }
        })(jQuery);

        function checkradio(e) {
            e.preventDefault();
            var chval = $('#tosradio').is(':checked')
            if ($('#tosradio').is(':checked')) {
                $('#myModal__').modal('show');
            }else{
                $('.error-terms').css({
                    'color':'#f00'
                })
                console.log($(this).parent().attr('class'));
            }
        }

    </script>
@endsection

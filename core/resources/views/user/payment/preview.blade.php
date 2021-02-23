@extends('user')
@section('content')
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

                <div class="col-xl-10">
                    @include('errors.alert')
                </div>

                <div class="col-xl-10">
                    <div class="terms">
                        <form method="POST" action="{{route('deposit.confirm')}}">
                            {{csrf_field()}}
                            <div class="card text-center">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <img src="{{asset('assets/images/gateway')}}/{{$data->gateway_id}}.jpg"
                                             style="max-width:100px; max-height:100px; margin:0 auto;"/>
                                    </li>
                                    <li class="list-group-item"> Amount : {{$data->amount}}
                                        <strong>{{$basic->currency}}</strong>
                                    </li>


                                    <li class="list-group-item"> Charge :
                                        <strong>{{$data->charge}} </strong>{{ $basic->currency }}</li>
                                    <li class="list-group-item "> Payable :
                                        <strong>{{$data->charge + $data->amount}} </strong>{{ $basic->currency }}</li>


                                    <li class="list-group-item"> In USD :
                                        <strong>${{$data->usd}}</strong>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="btn-wrapper">
                                            <input type="submit" class="submit-btn btn-block" id="btn-confirm" value="Pay Now">
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    @if($data->gateway_id == 107)
        <form action="{{ route('ipn.paystack') }}" method="POST">
            @csrf
            <script
                src="//js.paystack.co/v1/inline.js"
                data-key="{{ $data->gateway->val1 }}"
                data-email="{{ $data->user->email }}"
                data-amount="{{ round($data->usd/$data->gateway->val7, 2)*100 }}"
                data-currency="NGN"
                data-ref="{{ $data->trx }}"
                data-custom-button="btn-confirm">
            </script>
        </form>
    @elseif($data->gateway_id == 108)
        <script src="//voguepay.com/js/voguepay.js"></script>
        <script>
            closedFunction = function () {

            }
            successFunction = function (transaction_id) {
                window.location.href = '{{ url('user/vogue') }}/' + transaction_id + '/success';
            }
            failedFunction = function (transaction_id) {
                window.location.href = '{{ url('user/vogue') }}/' + transaction_id + '/error';
            }

            function pay(item, price) {
                //Initiate voguepay inline payment
                Voguepay.init({
                    v_merchant_id: "{{ $data->gateway->val1 }}",
                    total: price,
                    notify_url: "{{ route('ipn.voguepay') }}",
                    cur: 'USD',
                    merchant_ref: "{{ $data->trx }}",
                    memo: 'Buy ICO',
                    recurrent: true,
                    frequency: 10,
                    developer_code: '5af93ca2913fd',
                    store_id: "{{ $data->user_id }}",
                    custom: "{{ $data->trx }}",

                    closed: closedFunction,
                    success: successFunction,
                    failed: failedFunction
                });
            }

            $(document).ready(function () {
                $(document).on('click', '#btn-confirm', function (e) {
                    e.preventDefault();
                    pay('Buy', {{ $data->usd }});
                });
            })
        </script>

    @endif
@endsection

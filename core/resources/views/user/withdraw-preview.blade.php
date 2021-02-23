@extends('user')
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>


    <div class="our-mentors">

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card  ">
                        <div class="card-header text-center">
                            <h4 class="name">{{ $method->name }}</h4>
                        </div>
                        <div style="font-size: 18px;padding: 18px;" class="card-body text-center">
                            <img class="" style="width: 35%;border-radius: 5px"
                                 src="{{ asset('assets/images') }}/{{ $method->image }}" alt="">
                        </div>
                        <ul style='font-size: 15px;' class="list-group text-center bold">
                            <li class="list-group-item">Limit - ( {!! $method->withdraw_min !!}
                                to {{ $method->withdraw_max }} ) {{ $basic->currency }} </li>
                            <li class="list-group-item"> Fix Charge - {{ $method->fix }} {{ $basic->currency }}</li>
                            <li class="list-group-item"> Percentage - {{ $method->percent }}%</li>
                            <li class="list-group-item">Duration - {!! $method->duration !!} Days</li>
                        </ul>
                        <div class="card-footer" style="overflow: hidden">

                            <div class="btn-wrapper">
                                <a href="{{ route('withdraw.money') }}"
                                   class="submit-btn btn text-decoration text-white">
                                    <i class="fa fa-arrow-left"></i> Another Method
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="name">Withdraw Preview</h4>
                        </div>
                        <!-- panel body -->
                        <div class="card-body">
                            <div class="text-center">
                                <h3 class="text-uppercase">Current Balance :
                                    <strong>{{number_format( $balance->balance, $basic->decimal) }}
                                        - {{ $basic->currency }}</strong></h3>
                            </div>
                            <hr>
                            <div class="form-group">
                                <h6>Request Amount : </h6>
                                <div class="input-group">
                                    <input type="text" value="{{ $withdraw->amount }}" readonly name="amount"
                                           id="amount" class="form-control form-control-lg"
                                           placeholder="Enter Deposit Amount" required>
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">{{$basic->currency}}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <h6>Withdrawal Charge : </h6>
                                <div class="input-group">
                                    <input type="text" value="{{ round($withdraw->charge,$basic->decimal )}}"
                                           readonly name="charge"  class="form-control form-control-lg"
                                           placeholder="Enter Deposit Amount" required>
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">{{$basic->currency}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <h6>Total Amount : </h6>
                                <div class="input-group">
                                    <input type="text" value="{{ $withdraw->net_amount }}" readonly
                                           name="charge" class="form-control form-control-lg"
                                           placeholder="Enter Deposit Amount" required>
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">{{$basic->currency}}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <h6>Available Balance :</h6>
                                <div class="input-group">
                                    <input type="text" value="{{ $balance->balance - $withdraw->net_amount }}"
                                           readonly name="charge" class="form-control form-control-lg"
                                           placeholder="Enter Deposit Amount" required>
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">{{$basic->currency}}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <!-- panel head -->
                        <div class="card-header">
                            <i class="fa fa-send"></i> <strong>Payment Send Details</strong>
                        </div>
                        <!-- panel body -->
                        <div class="card-body">
                            <div class="col-md-12">

                                <form method="post" action="{{route('withdraw.submit')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}">
                                    <div class="row">
                                        <div class="form-group col-md-6">

                                                        <textarea name="send_details" rows="4"
                                                                  class="form-control form-control-lg"
                                                                  placeholder="Sending Details" required></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                                         <textarea name="message" rows="4"
                                                                   class="form-control form-control-lg"
                                                                   placeholder="Message ( If Any )"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="submit"
                                                    class="submit-btn"><i
                                                    class="fa fa-send"></i> Submit Withdraw
                                            </button>
                                        </div>


                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@stop

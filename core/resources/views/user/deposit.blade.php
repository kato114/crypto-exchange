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
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="area-title">
                        <h2>Select a Payment Gateway</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @include('errors.alert')
                </div>
                @foreach($gates as $gate)
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="single-member">
                            <div class="part-title">
                                <h4>{{$gate->name}}</h4>
                            </div>
                            <div class="part-img">
                                <img src="{{asset('assets/images/gateway')}}/{{$gate->id.'.jpg'}}"
                                     alt="image">
                            </div>
                            <div class="btn-wrapper">
                                <button data-toggle="modal"
                                        data-target="#depositModal{{$gate->id}}"
                                        class="submit-btn">Select
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="depositModal{{$gate->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Deposit via <strong>{{$gate->name}}</strong></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{route('deposit.data-insert')}}">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="gateway" value="{{$gate->id}}">
                                        <label><strong>DEPOSIT AMOUNT</strong>
                                            <span class="modal-msg">({{ $gate->minamo }} - {{$gate->maxamo }}
                                                ) {{$basic->currency}}
                                                <br>
                                               <code
                                                   class="font-weight-bold">Charged {{ $gate->fixed_charge }} {{$basic->currency}}
                                                   + {{ $gate->percent_charge }}%</code>
                                        </span>
                                        </label>
                                        <hr/>

                                        <div class="input-group input-group-lg mb-3">

                                            <input type="text" class="form-control " name="amount" placeholder="0.00"
                                                   aria-label="amount"
                                                   onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                   placeholder=" Enter Amount" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"
                                                      id="basic-addon1">{{$basic->currency}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ">Preview</button>
                                        <button type="button" class="btn btn-danger " data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>



@stop

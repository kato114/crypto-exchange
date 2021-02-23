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
                <div class="col-lg-12 col-md-12">
                    @include('errors.error')
                    @include('errors.alert')
                </div>


                @foreach($withdrawMethod as $gate)
                    <div class="col-md-3 col-sm-6 ">

                        <div class="single-member">
                            <div class="part-title">
                                <h4>{{$gate->name}}</h4>
                            </div>
                            <div class="part-img">
                                <img src="{{asset('assets/images/')}}/{{$gate->image}}"
                                     style="width:50%; margin: 10px 25% ;">
                                <ul style="font-size: 15px;" class="list-group text-center">
                                    <li class="list-group-item">Minimum
                                        - {{$gate->withdraw_min}} {{ $basic->currency }} </li>
                                    <li class="list-group-item">Maximum
                                        - {{$gate->withdraw_max}} {{ $basic->currency }} </li>
                                    <li class="list-group-item"> Charge - {{$gate->fix}} {{ $basic->currency }}
                                        + {{$gate->percent}}%
                                    </li>
                                    <li class="list-group-item">Processing Time - {{$gate->duration}} Days</li>
                                </ul>
                            </div>

                            <div class="btn-wrapper">
                                <button data-toggle="modal"
                                        data-target="#withdrawModal{{$gate->id}}"
                                        class="submit-btn">Select
                                </button>
                            </div>
                        </div>


                    </div>
                    <!--Buy Modal -->
                    <div id="withdrawModal{{$gate->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Withdraw via <strong>{{$gate->name}}</strong></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <form method="POST" action="{{route('withdraw.preview') }}">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input type="hidden" name="method_id" value="{{$gate->id}}">
                                        <label class="col-md-12 modal-msg-heading"><strong>Limit</strong>
                                            <span class="modal-msg ">({{ $gate->withdraw_min }}
                                                - {{$gate->withdraw_max }}) {{$basic->currency}}
                                                <br>
                                                Charge {{ $gate->fix }} {{$basic->currency}} + {{ $gate->percent }}
                                                %</span>
                                        </label>

                                        <hr/>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="amount" class="form-control" id="amount"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder=" Enter Amount" autocomplete="off"
                                                       required>
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"
                                                      id="basic-addon1">{{$basic->currency}}</span>
                                                </div>
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

@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-exchange"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">Add Currency
                    <a href="{{route('currency.index')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Currency
                    </a>
                </h3><br>


                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form role="form" method="POST" action="{{route('currency.store')}}" name="editForm" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <h5>Currency  Name:</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" placeholder="Currency  Name" value="{{old('name')}}"
                                                   name="name">
                                            <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-globe"></i>
                                            </span>
                                            </div>
                                        </div>
                                        @if ($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <h5> Currency 	Symbol:</h5>
                                        <input type="text" class="form-control form-control-lg" placeholder="Currency Symbol" value="{{old('symbol')}}"
                                               name="symbol">
                                        @if ($errors->has('symbol'))
                                            <div class="error">{{ $errors->first('symbol') }}</div>
                                        @endif

                                    </div>

                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <h5>Price:</h5>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><strong> 1 = {{$basic->currency}}</strong></span>
                                            </div>
                                            <input type="text" name="price"  value="{{old('price')}}" class="form-control form-control-lg"
                                                   onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                        </div>
                                        @if ($errors->has('price'))
                                            <div class="error">{{ $errors->first('price') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <h5> Available Balance </h5>
                                        <div class="input-group">
                                            <input type="text" name="available_balance" value="{{old('available_balance')}}" class="form-control form-control-lg"
                                                   placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><strong>Amount</strong></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('available_balance'))
                                            <div class="error">{{ $errors->first('available_balance') }}</div>
                                        @endif
                                    </div>



                                    <div class="form-group col-md-6">
                                        <h5> Payment ID</h5>
                                            <input type="text" name="payment_id"  value="{{old('payment_id')}}" name="payment_id" class="form-control form-control-lg"
                                                   placeholder="Payment Id" >
                                        @if ($errors->has('payment_id'))
                                            <div class="error">{{ $errors->first('payment_id') }}</div>
                                        @endif
                                    </div>


                                        <div class="form-group col-md-6">
                                            <h5> Exchange Charge(%)</h5>
                                            <div class="input-group">
                                                <input type="text" name="exchange"  value="{{old('exchange')}}" name="exchange" class="form-control form-control-lg"
                                                       placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><strong>%</strong></span>
                                                </div>
                                            </div>
                                            @if ($errors->has('exchange'))
                                                <div class="error">{{ $errors->first('exchange') }}</div>
                                            @endif
                                        </div>




                                    <div class="form-group col-md-6">
                                        <h5> Buying Charge(%)</h5>
                                        <div class="input-group">
                                            <input type="text" name="buy" value="{{old('buy')}}" class="form-control form-control-lg"
                                                   placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><strong>%</strong></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('buy'))
                                            <div class="error">{{ $errors->first('buy') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <h5> Selling Charge(%)</h5>
                                        <div class="input-group">
                                            <input type="text" name="sell"  value="{{old('sell')}}" class="form-control form-control-lg"
                                                   placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">

                                            <div class="input-group-append">
                                                <span class="input-group-text"><strong>%</strong></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('sell'))
                                            <div class="error">{{ $errors->first('sell') }}</div>
                                        @endif
                                    </div>
                                </div>



                                <div class="row">
                                    <div class=" col-md-6">
                                            <div class="form-group ">
                                                <h5>Is Coin ? </h5>
                                                <input data-toggle="toggle" data-size="large" data-onstyle="success" data-on="Yes" data-off="No"
                                                       data-offstyle="danger" data-width="100%" type="checkbox" name="is_coin">
                                            </div>

                                            <div class="form-group">
                                                <h5>Status:</h5>
                                                <input data-toggle="toggle" data-size="large" data-onstyle="success"
                                                       data-offstyle="danger" data-width="100%" type="checkbox" name="status">
                                            </div>

                                    </div>
                                    <div class=" col-md-6">
                                        <div class="form-group ">
                                            <h5>Image</h5>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                                     data-trigger="fileinput">
                                                    <img style="width: 200px"
                                                         src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text= Image"
                                                         alt="...">

                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px"></div>
                                                <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                            class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                            class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists bold uppercase"
                                                       data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                                </div>
                                            </div>
                                            @if ($errors->has('image'))
                                                <div class="error">{{ $errors->first('image') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 ">
                                        <button class="btn btn-primary btn-block btn-lg">Save</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop
@section('script')
    <script src="{{ asset('assets/admin/js/nicEdit-latest.js') }}"></script>

    <script>
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel: true}).panelInstance('area1');
        });
    </script>
@stop

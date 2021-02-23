@extends('admin')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-handshake-o"></i>  {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success btn-md pull-right" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i> Create New
            </button>
        </div>
        <br>
        <br>

        <div class="col-md-12">
        @include('errors.error')
        </div>

        <br>
        @foreach($ourClient as $key => $data)
            <div class="col-md-4">
                <div class="tile">
                    <div class="tile-title text-center">

                        <img src="{{asset('assets/images/our-client/'.$data->image)}}" width="40%" alt="Card image cap"><br><br>
                    </div>
                    <div class="tile-body">

                        <a href="{!! $data->link !!}" class="title  text-center">{!! $data->link !!}</a>
                    </div>
                    <div class="tile-footer text-center">
                        <button class="btn btn-danger delete_button"
                           data-toggle="modal" data-target="#DelModal"
                           data-id="{{ $data->id }}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="modal fade editModal" id="addModal" tabindex="-1"
         role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add
                        <strong>New Client</strong></h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                </div>
                <form method="post" action="{{route('store.client')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Client Logo"
                                         alt="*"/></div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                                        <span class="btn btn-success btn-file">
                                                            <span class="fileinput-new"> Change Image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="image"> </span>
                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h6 for="val1"><strong>Website Link</strong></h6>
                            <input type="text"
                                   class="form-control" id="link" name="link">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success ">Save Changes</button>
                        <button type="button" class=" btn btn-danger" data-dismiss="modal"
                                aria-hidden="true">Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('delete.client') }}" >
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" class="abir_id" value="0">

                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Yes</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash"></i> No</button>&nbsp;
                    </form>
                </div>

            </div>
        </div>
    </div>

@stop

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                $(".abir_id").val(id);
            });
        });
    </script>
@stop

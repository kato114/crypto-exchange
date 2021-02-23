@extends('admin')
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-info-circle"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">


                <h3 class="tile-title "> {{$page_title}}

                    <a href="{{route('menu-create')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-plus"></i> Create Menu
                    </a>
                </h3>
                <br><br>

                <div class="tile-body">
                    <div class="row">
                        @foreach($menus as $m)
                            <div class="col-md-6">
                                <h3  class="text-center">{{ $m->name }}</h3>
                                <br>
                                <p class="text-center">
                                    {!! $m->description !!}
                                </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('menu-edit',$m->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit Menu </a>
                                        <button type="button" class="btn btn-danger delete_button"
                                                data-toggle="modal" data-target="#DelModal"
                                                data-id="{{ $m->id }}">
                                            <i class='fa fa-trash'></i> Delete Menu
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <br><br>
                    {!! $menus->links() !!}
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('menu-delete') }}" >
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" class="abir_id" value="0">

                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


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

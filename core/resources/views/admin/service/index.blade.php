@extends('admin')
@section('import-css')
    <link href="{{asset('assets/admin/fonts/flaticon.css')}}" rel="stylesheet">
@stop


@section('body')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-th"></i> Manage {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}} Section</h3>
                <div class="tile-body">
                    <form action="{{route('testimonial.text')}}" method="post">
                        @csrf

                        <div class="form-group col-md-10 offset-md-1">
                            <h5>Title</h5>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="service_heading" class="form-control form-control-lg"
                                           placeholder="Title"
                                           value="{{ $basic->service_heading }}">
                                    <div class="input-group-append"><span class="input-group-text"><i
                                                class="fa fa-file-text"></i></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group  col-md-10 offset-md-1">
                            <h5>Sort Details</h5>
                            <textarea name="service_para" class="form-control-lg form-control" placeholder="Details"
                                      rows="3">{{$basic->service_para}}</textarea>
                        </div>


                        <div class="form-group">
                            <div class="col-10 offset-1">
                                <button type="submit" class="btn btn-primary btn-block btn-lg"><i
                                        class="fa fa-send"></i> UPDATE
                                </button>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">All {{$page_title}}
                    <button type="button" class="btn btn-success btn-md pull-right" data-toggle="modal"
                            data-target="#myModal">Create Service
                    </button>
                </h3>
                @include('errors.error')
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column" id="">
                            <thead>
                            <tr>
                                <th scope="col" >Icon</th>
                                <th scope="col" style="width: 15%">Title</th>
                                <th scope="col">Details</th>
                                <th scope="col" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mentors as $k=>$data)
                                <tr>
                                    <td data-label="Icon">
                                       <div style="font-size: 100px"> {!! $data->icon !!}</div>
                                    </td>
                                    <td data-label="Title"><strong>{{$data->title }}</strong></td>
                                    <td data-label="Details">{{$data->details }}</td>
                                    <td data-label="Action">
                                        <button type="button" data-route="{{route('service.update', $data->id)}}" data-title="{{$data->title}}"  data-details="{{$data->details}}" data-icon="{{$data->icon}}"  class="btn btn-info btn-sm edit_button" data-toggle="modal" data-target="#editService">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <a href="#" class=" delete_button btn btn-sm btn-danger"
                                           data-toggle="modal" data-target="#DelModal"  data-route="{{route('service.destroy',$data->id)}}">
                                            <i class='fa fa-trash'></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>

                        {{$mentors->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>








    <!-- Create Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4><i class='fa fa-plus'></i> Create Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{route('service.store')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <h5> Title</h5>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" value="{{old('title')}}"
                                       name="title">
                                <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <h5> Icon</h5>
                            <div class="input-group">
                                <input type="text" class=" form-control form-control-lg" value="{{old('icon')}}"
                                       name="icon">
                                <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                </div>
                            </div>
                           <span> You can use more icon from <code>https://www.flaticon.com/</code></span>

                        </div>

                        <div class="form-group">
                            <h5>Details</h5>
                            <textarea name="details" id="area1" rows="6"
                                      class="form-control form-control-lg">{{old('details')}}</textarea>
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editService" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4><i class='fa fa-pencil'></i> Update Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="" class="edit_id" enctype="multipart/form-data">
                    @csrf
                    {{method_field('put')}}

                    <div class="modal-body">
                        <div class="form-group">
                            <h5> Title</h5>
                            <div class="input-group">
                                <input type="text" class="edit_title form-control form-control-lg" value="{{old('title')}}"
                                       name="title">
                                <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <h5> Icon</h5>
                            <div class="input-group">
                                <input type="text" class="edit_icon form-control form-control-lg" value="{{old('icon')}}"
                                       name="icon">
                                <div class="input-group-append"><span class="input-group-text show_icon">
                                            <i class="fa fa-font"></i>
                                            </span>
                                </div>
                            </div>
                            <span> You can use more icon from <code>https://www.flaticon.com/</code></span>
                        </div>

                        <div class="form-group">
                            <h5>Details</h5>
                            <textarea name="details" id="area1" rows="6"
                                      class="edit_details form-control form-control-lg">{{old('details')}}</textarea>
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>



    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
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
                    <form method="post" action="" class="destroy_id">
                        @csrf
                        {{ method_field('delete') }}

                        <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i> Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No
                        </button>&nbsp;

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var route = $(this).data('route');
                $(".destroy_id").attr('action',route);

            });


            $(document).on('click','.edit_button', function (e) {
                var route = $(this).data('route') ;
                var title = $(this).data('title') ;
                var icon = $(this).data('icon');
                var details = $(this).data('details');

                $(".edit_title").val(title);
                $(".edit_icon").val(icon);
                $(".show_icon").html(icon);
                $(".edit_details").val(details);
                $('.edit_id').attr('action', route);
            })


        });
    </script>
@endsection

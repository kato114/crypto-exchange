@extends('admin')

@section('body')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-quote-left"></i> Manage {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>






    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">All {{$page_title}}

                    <a href="{{route('testimonial.create')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-plus"></i> Add New Testimonial
                    </a>

                </h3>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column" id="">
                            <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Details</th>
                                <th scope="col" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $k=>$data)
                                <tr>
                                    <td data-label="SL">{{++$k}}</td>
                                    <td data-label="Name">
                                        <strong>{{$data->name }}</strong>
                                    </td>
                                    <td data-label="designation">{{$data->designation }}</td>
                                    <td data-label="Details">{{$data->details }}</td>
                                    <td data-label="Action">
                                        <a class=" btn btn-info btn-sm"
                                           href="{{route('testimonial.edit',$data->id)}}"><i
                                                class="fa fa-pencil"></i></a>

                                        <a href="#" class=" delete_button btn btn-sm btn-danger"
                                           data-toggle="modal" data-target="#DelModal"
                                           data-id="{{ $data->id }}">
                                            <i class='fa fa-trash'></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>

                        {{$posts->links()}}
                    </div>
                </div>
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
                    <form method="post" action="{{ route('testimonial.delete') }}" >
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}

                        <input type="hidden" name="id" class="abir_id" value="0">
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
                var id = $(this).data('id');
                $(".abir_id").val(id);
            });
        });
    </script>
@endsection

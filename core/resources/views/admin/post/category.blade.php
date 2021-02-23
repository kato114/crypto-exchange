@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-newspaper"></i>  {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title ">
                    <button type="button" class="btn btn-success btn-md pull-right edit_button"
                            data-toggle="modal" data-target="#myModal"
                            data-act="Add New"
                            data-name=""
                            data-id="0">
                        <i class="fa fa-plus"></i> ADD Category
                    </button>
                    <br>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th> Name</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($events as $k=>$mac)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{$mac->name}}</td>
                                    <td>
                                        <span class="badge  badge-pill  badge-{{ $mac->status ==0 ? 'warning' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="Edit"
                                                data-name="{{$mac->name}}"
                                                data-status="{{$mac->status}}"
                                                data-id="{{$mac->id}}">
                                            <i class="fa fa-edit"></i> EDIT
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Category </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('update.cat')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control form-control-lg abir_id" type="hidden" name="id">
                            <input class="form-control form-control-lg abir_name" name="name" placeholder=" Name"
                                   required>
                            <br>
                        </div>
                        <div class="form-group">
                            <select name="status" id="event-status" class="form-control form-control-lg abir_status" required>
                                <option value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>
                            </select>
                            <br>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var name = $(this).data('name');
                var status = $(this).data('status');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".abir_id").val(id);
                $(".abir_name").val(name);
                $(".abir_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });
        });
    </script>
@endsection

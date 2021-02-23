@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bank"></i>  {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title "> <i class="fa fa-bank"></i> {{$page_title}}
                    <button type="button" class="btn btn-success btn-md pull-right "
                            data-toggle="modal" data-target="#addModal"
                            data-act="Add New"
                            data-name=""
                            data-id="0">
                        <i class="fa fa-plus"></i> Add Bank
                    </button>
                    <br>
                </div>
                <div class="tile-body">

                    @include('errors.error')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Bank Name</th>
                                <th>Payment Details</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($banks as $k=>$mac)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{$mac->name}}</td>
                                    <td>{{$mac->account}}</td>

                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="Edit"
                                                data-name="{{$mac->name}}"
                                                data-account="{{$mac->account}}"
                                                data-route="{{route('banks.update', $mac->id)}}"
                                                data-id="{{$mac->id}}">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <button type="button" class="btn btn-outline-danger btn-sm delete_button"
                                                data-toggle="modal" data-target="#delModal"
                                                data-route="{{route('banks.destroy',$mac->id)}}"
                                                data-id="{{$mac->id}}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$banks->links()}}

                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Add button -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bank"></i> Add Bank </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('banks.store')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <h4>Bank Name:</h4>
                            <input class="form-control form-control-lg " name="name" placeholder="Bank Name">
                        </div>
                        <div class="form-group">
                            <h4> Payment Details:</h4>
                            <textarea name="account"  placeholder="Payment Details" class="form-control form-control-lg"  rows="10"></textarea>
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

    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bank"></i> <strong class="abir_act"></strong> Bank </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="" class="edit_banks">
                    {{ csrf_field() }}
                    {{method_field('put')}}
                    <div class="modal-body">
                        <div class="form-group">
                            <h4>Bank Name:</h4>
                            <input class="form-control form-control-lg abir_id" type="hidden" name="id">
                            <input class="form-control form-control-lg abir_name" name="name" placeholder="Bank Name"
                                   required>
                        </div>
                        <div class="form-group">
                            <h4> Payment Details:</h4>
                            <textarea name="account"  placeholder="Payment Details" class="edit_account form-control form-control-lg"  rows="10"></textarea>
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

    <!-- Modal for Delete button -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Delete Bank </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="" class="delete_banks">
                    {{ csrf_field() }}
                    {{method_field('delete')}}
                    <div class="modal-body">
                        <h5>Are you sure to delete this??</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
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
                var route = $(this).data('route');
                $(".edit_banks").attr('action',route);

                var name = $(this).data('name');
                var status = $(this).data('status');
                var account = $(this).data('account');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".abir_id").val(id);
                $(".abir_name").val(name);
                $(".edit_account").val(account);
                $(".abir_act").text(act);

            });

            $(document).on("click", '.delete_button', function (e) {
                var route = $(this).data('route');
                $(".delete_banks").attr('action',route);
            });
        });
    </script>
@endsection

@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-font-awesome"></i>  {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title "> <i class="fa fa-font-awesome"></i> {{$page_title}}</h3>
                <div class="tile-body">

                    @include('errors.error')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Provider</th>
                                <th>Client Id</th>
                                <th>Client Secret</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($providers as $k=>$mac)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{$mac->provider}}</td>
                                    <td>{{$mac->client_id}}</td>
                                    <td>{{$mac->client_secret}}</td>

                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="Edit"
                                                data-name="{{$mac->client_id}}"
                                                data-account="{{$mac->client_secret}}"
                                                data-route="{{route('social-login', $mac->id)}}"
                                                data-id="{{$mac->id}}">
                                            <i class="fa fa-edit"></i> Edit
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
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-font-awesome"></i> <strong class="abir_act"></strong> App Key & Secret Id </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="" class="edit_banks">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <h4>Client Id :</h4>
                            <input class="form-control form-control-lg abir_id" type="hidden" name="id">
                            <input class="form-control form-control-lg abir_name" name="name" placeholder="Client Id "
                                   required>
                        </div>
                        <div class="form-group">
                            <h4> Client Secret :</h4>
                            <input class="form-control form-control-lg edit_account" name="account" placeholder="Client Secret" required>
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

        });
    </script>
@endsection

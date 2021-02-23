@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">{{$page_title}}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title "> <i class="fa fa-users"></i>  User List</h3>


                <div class="tile-body">
                    <div class="pull-right icon-btn">
                        <form method="get" class="form-inline" action="{{route('search.users')}}">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                            <button class="btn btn-outline btn-circle  green" type="submit"><i
                                    class="fa fa-search"></i></button>

                        </form>
                    </div>
                    <br><br>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users) >0)
                                @foreach($users as $user)
                                    <tr>
                                        <td data-label="Name">{{$user->fname}} {{$user->lname}}</td>
                                        <td data-label="Email">{{$user->email}}</td>
                                        <td data-label="Username">{{$user->username}}</td>
                                        <td data-label="Mobile">{{isset($user->phone) ? $user->phone : 'N/A'}}</td>
                                        <td data-label="Balance"><strong>{{$user->balance}} {{$basic->currency}}</strong></td>
                                        <td data-label="Details">
                                            <a href="{{route('user.single', $user->id)}}"
                                               class="btn btn-outline-primary ">
                                                <i class="fa fa-eye"></i> View </a>
                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="6">
                                        <strong>No Users Found !!!</strong>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>


@endsection

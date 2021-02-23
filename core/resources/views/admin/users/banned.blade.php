@extends('admin')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}</h3>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr>
                                <th scope="col"> Name</th>
                                <th scope="col"> Email</th>
                                <th scope="col"> Username</th>
                                <th scope="col"> Phone</th>
                                <th scope="col"> Balance</th>
                                <th scope="col">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td data-label="Name">
                                        {{$user->fname}} {{$user->lname}}
                                    </td>
                                    <td data-label="Email">
                                        {{$user->email}}
                                    </td>
                                    <td data-label="Username">
                                        {{$user->username}}
                                    </td>
                                    <td data-label="Phone">
                                        {{$user->phone}}
                                    </td>
                                    <td data-label="Balance">
                                        {{number_format(floatval($user->balance), $basic->decimal, '.', '')}} {{$basic->currency_symbol}}
                                    </td>
                                    <td data-label="Details">
                                        <a href="{{route('user.single', $user->id)}}"
                                           class="btn btn-outline-primary ">
                                            <i class="fa fa-eye"></i> View </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>
                        <?php echo $users->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

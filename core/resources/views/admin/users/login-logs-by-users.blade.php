@extends('admin')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{$page_title}}</h3>

                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover">
                            <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">IP</th>
                                <th scope="col">Location</th>
                                <th scope="col">Details</th>
                                <th scope="col">Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td data-label="Username"><a
                                            href="{{route('user.single',$log->user->id)}}">{{$log->user->username}}</a></td>
                                    <td data-label="User IP">{{$log->user_ip}}</td>
                                    <td data-label="User Location">{{$log->location}}</td>
                                    <td data-label="Details">{{$log->details}}</td>
                                    <td data-label="Time">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

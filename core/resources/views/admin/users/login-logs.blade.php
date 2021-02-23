@extends('admin')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Questions LIST</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover order-column">
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
                                <td data-label="Username"><a href="{{route('user.single',$log->user->id)}}">{{$log->user->name}}</a></td>
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

@endsection

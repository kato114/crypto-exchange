@extends('admin')
@section('css')
@stop
@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> {{$page_title}}</h1>
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
                    <a href="{{route('faqs-create')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-plus"></i> Create Faqs
                    </a>
                    <br>
                </div>



                <div class="tile-body">
                    <div id="accordion">
                        @foreach($faqs as $key => $f)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{ $f->id }}" aria-expanded="true" aria-controls="collapseOne{{ $f->id }}">
                                       <h4> {{ $f->title }}</h4>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne{{ $f->id }}" class="collapse @if($key == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    {!! $f->description !!}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('faqs-edit',$f->id) }}" class="btn btn-primary btn-block bold uppercase"><i class="fa fa-edit"></i> Edit faqs</a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger bold uppercase btn-block delete_button"
                                                    data-toggle="modal" data-target="#DelModal"
                                                    data-id="{{ $f->id }}">
                                                <i class='fa fa-trash'></i> Delete faqs
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                            @endforeach

                    </div>

                    <div class="text-center">
                        {!! $faqs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal for DELETE -->
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title bold" id="myModalLabel"> <i class='fa fa-exclamation-triangle'></i>Delete Confirmation !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('faqs-delete') }}" >
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" class="abir_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> DELETE</button>
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

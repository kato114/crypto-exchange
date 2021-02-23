<div class="col-xl-12 col-sm-12 col-md-6 col-lg-12">
    <div class="post-widget">
        <div class="title">
            <h3>Latest Posts</h3>
        </div>

        @foreach($post as $data)
        <div class="single-post">
            <div class="part-img">
                <img src="{{asset('assets/images/post/'.$data->image)}}" alt="">
            </div>
            <div class="part-text">
                <a href="{{route('blog.details',[$data->id,str_slug($data->title)])}}">
                    {{$data->title}}
                </a>
                <h5><span><i class="far fa-clock"></i></span>{{$data->created_at->diffForHumans()}}</h5>
            </div>
        </div>
            @endforeach

    </div>


</div>

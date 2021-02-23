<div class="cat-widget">
    <div class="title">
        <h3>Categories</h3>
    </div>
    <div class="category">
        <ul>
            @foreach($category as $data)
                <li><a href="{{route('cats.blog',[$data->id, str_slug($data->name)])}}">{{$data->name}}<span>({{$data->posts()->count()}})</span></a></li>
            @endforeach
        </ul>
    </div>
</div>

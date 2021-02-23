<div class="social-widget">
    <div class="title">
        <h3>Follow Us</h3>
    </div>
    <div class="social">
        @foreach($social as $data)
            <a href="{{$data->link}}">{!! $data->code !!}</a>
        @endforeach

    </div>
</div>

<div>
    <p>Halo</p>
    @foreach ($posts as $post)
        <h2>{{ $post -> title }}<h2>
        @if($post -> published)
            <span>published</span>
        @else
            <span>draft</span>
        @endif
    @endforeach
</div>

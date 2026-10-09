@foreach ($posts as $post)
    <article nitro:key="{{ $post['id'] }}">...</article>
@endforeach

@if ($this->hasMore('posts'))
    <div nitro:visible="$loadMore('posts')">Loading…</div>
@endif

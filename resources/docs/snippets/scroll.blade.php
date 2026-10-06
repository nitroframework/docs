@foreach ($posts as $post)
    <article fusion:key="{{ $post['id'] }}">...</article>
@endforeach

@if ($this->hasMore('posts'))
    <div fusion:visible="$loadMore('posts')">Loading…</div>
@endif

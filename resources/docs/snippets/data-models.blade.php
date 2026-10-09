@foreach ($posts as $post)
    <article nitro:key="{{ $post->id }}">
        <h3>{{ $post->title }}</h3>
        <p>By {{ $post->author->name }}</p>

        @if ($post->published_at === null)
            <button nitro:click="publish($post)">Publish</button>
        @endif
    </article>
@endforeach

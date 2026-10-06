@foreach ($posts as $post)
    <article fusion:key="{{ $post->id }}">
        <h3>{{ $post->title }}</h3>
        <p>By {{ $post->author->name }}</p>

        @if ($post->published_at === null)
            <button fusion:click="publish($post)">Publish</button>
        @endif
    </article>
@endforeach

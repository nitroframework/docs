@foreach ($posts as $post)   {{-- public Collection $posts: Post models --}}
    <button fusion:click="remove($post)">Delete</button>
    <button fusion:click="setStatus($post->id, 'published')">Publish</button>
@endforeach

@foreach ($posts as $post)   {{-- public Collection $posts: Post models --}}
    <button nitro:click="remove($post)">Delete</button>
    <button nitro:click="setStatus($post->id, 'published')">Publish</button>
@endforeach

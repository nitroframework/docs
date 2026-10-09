{{-- This link's visit, inside a View Transition. --}}
<a href="{{ route('posts.show', $post) }}" nitro:navigate.transition>{{ $post->title }}</a>

{{-- With nitro:prefetch: asked for in view, shown with a transition. --}}
<a href="{{ route('posts.show', $post) }}" nitro:navigate.transition nitro:prefetch.visible>{{ $post->title }}</a>

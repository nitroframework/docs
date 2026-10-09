<a href="{{ route('posts.index') }}" nitro:navigate>Posts</a>

<a href="{{ route('posts.index') }}" nitro:navigate.keypress>Starts on mouse down</a>
<a href="?tab=comments" nitro:navigate.preserve-scroll>Keeps the scroll position</a>
<a href="{{ route('posts.index') }}" nitro:navigate nitro:current="font-bold">Bold while current</a>

<a href="/posts" nitro:navigate>Posts</a>                                    {{-- no prefetch --}}
<a href="/posts" nitro:navigate nitro:prefetch>Posts</a>                     {{-- fetch on hover --}}
<a href="/posts/hello-world" nitro:navigate nitro:prefetch.visible>Hello, world</a>   {{-- fetch when on screen --}}

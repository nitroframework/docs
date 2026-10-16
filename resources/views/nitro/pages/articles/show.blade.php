<article>
    <a nitro:navigate nitro:prefetch href="/blog" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white">← All posts</a>

    <header class="mt-6">
        <p class="text-sm text-slate-500">
            <time datetime="{{ $article['date'] }}">{{ $article['published'] }}</time> · {{ $article['minutes'] }} min read
        </p>
        <h1 class="mt-3 text-[2rem] leading-tight font-semibold tracking-tight text-slate-800 sm:text-4xl dark:text-slate-200">{{ $article['title'] }}</h1>
        @if ($article['description'] !== '')
            <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-400">{{ $article['description'] }}</p>
        @endif
        <p class="mt-6 flex items-center gap-2.5 text-sm">
            <span class="size-2 rounded-full nitro-gradient"></span>
            <span class="text-slate-500">By</span>
            <span class="font-medium text-slate-800 dark:text-slate-200">{{ $article['author'] }}</span>
        </p>
    </header>

    {{-- The post, rendered on the server from its Markdown (App\Articles\Articles). --}}
    <div class="prose-docs mt-10 border-t border-slate-200 pt-10 dark:border-white/10" data-content>
        {!! $html !!}
    </div>

    {{-- For search engines: the post as an article (Show::$schema). --}}
    <script type="application/ld+json">{!! $schema !!}</script>

    <aside class="mt-14 rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200 dark:bg-white/[0.03] dark:ring-white/10">
        <p class="font-semibold text-slate-900 dark:text-white">Try Nitro</p>
        <p class="mt-1 text-sm leading-6 text-slate-600 dark:text-slate-400">Install it in a Laravel app and build your first component in a few minutes.</p>
        <a nitro:navigate nitro:prefetch href="/docs/quickstart" class="mt-4 inline-flex rounded-lg px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-blue-500/25 transition hover:brightness-110 nitro-gradient">Read the quickstart</a>
    </aside>

    {{-- Newer / older --}}
    @if ($newer !== null || $older !== null)
        <nav class="mt-12 grid gap-4 border-t border-slate-200 pt-8 sm:grid-cols-2 dark:border-white/10">
            @if ($older !== null)
                <a nitro:navigate nitro:prefetch href="/blog/{{ $older['slug'] }}" rel="prev" class="group rounded-xl p-4 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:ring-white/10 dark:hover:ring-white/20">
                    <span class="text-xs text-slate-500">← Older</span>
                    <span class="mt-1 block font-semibold text-slate-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">{{ $older['title'] }}</span>
                </a>
            @endif
            @if ($newer !== null)
                <a nitro:navigate nitro:prefetch href="/blog/{{ $newer['slug'] }}" rel="next" class="group rounded-xl p-4 text-right ring-1 ring-slate-200 transition hover:ring-slate-300 sm:col-start-2 dark:ring-white/10 dark:hover:ring-white/20">
                    <span class="text-xs text-slate-500">Newer →</span>
                    <span class="mt-1 block font-semibold text-slate-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">{{ $newer['title'] }}</span>
                </a>
            @endif
        </nav>
    @endif
</article>

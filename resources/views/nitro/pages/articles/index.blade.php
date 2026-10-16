<div>
    <p class="mb-3 text-sm font-medium"><span class="nitro-text">Blog</span></p>
    <h1 class="text-[2rem] leading-tight font-semibold tracking-tight text-slate-800 sm:text-4xl dark:text-slate-200">News and deep dives</h1>
    <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-400">Releases, guides and how Nitro works inside.</p>

    {{-- Search: in the browser (Index::results()), once there are enough posts to need it. --}}
    @if (count($articles) > 3)
        <label class="relative mt-8 block">
            <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="4.5"/><path d="m10.5 10.5 3 3" stroke-linecap="round"/></svg>
            <input nitro:model="search" type="search" maxlength="100" placeholder="Search posts" aria-label="Search posts" class="demo-input pl-9">
        </label>
    @endif

    @if (count($this->results) === 0)
        <p class="mt-10 rounded-xl border border-dashed border-slate-300 px-4 py-8 text-center text-sm text-slate-500 dark:border-white/15">
            {{ $search === '' ? 'No posts yet.' : 'No posts match your search.' }}
        </p>
    @endif

    <ol class="mt-10 space-y-4">
        @foreach ($this->results as $article)
            <li nitro:key="{{ $article['slug'] }}">
                <article class="group relative rounded-2xl p-6 ring-1 ring-slate-200 transition hover:bg-slate-50/80 hover:ring-slate-300 dark:ring-white/10 dark:hover:bg-white/[0.03] dark:hover:ring-white/20">
                    <p class="text-xs text-slate-500">
                        <time datetime="{{ $article['date'] }}">{{ $article['published'] }}</time> · {{ $article['minutes'] }} min read
                    </p>
                    <h2 class="mt-2 text-xl font-semibold tracking-tight text-slate-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">
                        <a nitro:navigate nitro:prefetch href="/blog/{{ $article['slug'] }}">
                            <span class="absolute inset-0 rounded-2xl"></span>
                            {{ $article['title'] }}
                        </a>
                    </h2>
                    <p class="mt-2 text-[15px] leading-7 text-slate-600 dark:text-slate-400">{{ $article['description'] }}</p>
                    <p class="mt-4 text-sm font-medium text-browser-600 dark:text-browser-400">Read the post →</p>
                </article>
            </li>
        @endforeach
    </ol>
</div>

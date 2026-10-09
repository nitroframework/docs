<article class="mx-auto max-w-[46rem]">
    <p class="mb-3 text-sm font-medium"><span class="nitro-text">{{ $section }}</span></p>
    <h1 class="text-[2rem] leading-tight font-semibold tracking-tight text-zinc-800 sm:text-4xl dark:text-zinc-200">{{ $title }}</h1>
    @if ($lead !== '')
        <p class="mt-4 text-lg leading-8 text-zinc-600 dark:text-zinc-400">{{ $lead }}</p>
    @endif

    {{-- On small screens: "On this page" under the title (filled by resources/js/app.js). --}}
    <details class="group mt-6 rounded-xl ring-1 ring-zinc-200 xl:hidden dark:ring-white/10">
        <summary class="flex cursor-pointer list-none items-center justify-between px-4 py-2.5 text-sm font-medium text-zinc-700 dark:text-zinc-300">
            On this page
            <svg class="size-4 transition group-open:rotate-180" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m4 6 4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </summary>
        <nav data-toc class="border-t border-zinc-200 px-4 py-3 text-sm dark:border-white/10"></nav>
    </details>

    <div class="prose-docs mt-10" data-content>
        @foreach ($blocks as $i => $block)
            @if (isset($block['html']))
                {!! $block['html'] !!}
            @else
                {{-- A live example: a real component, running in the page. --}}
                <div class="not-prose relative my-8 overflow-hidden rounded-2xl ring-1 ring-zinc-200 dark:ring-white/10">
                    <div class="pointer-events-none absolute inset-x-0 -top-px h-px nitro-gradient opacity-70"></div>
                    <div class="flex items-center gap-2 border-b border-zinc-200/80 bg-zinc-50/80 px-4 py-2.5 dark:border-white/[0.07] dark:bg-white/[0.02]">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-60 motion-reduce:animate-none"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">{{ $block['title'] }}</span>
                        <span class="text-xs text-zinc-400 dark:text-zinc-500">live, in this page</span>
                        @if ($block['source'])
                            <a href="{{ $block['source'] }}" class="ml-auto text-xs font-medium text-zinc-500 hover:text-browser-600 dark:hover:text-browser-400">View source ↓</a>
                        @endif
                    </div>
                    <div class="bg-[radial-gradient(var(--color-zinc-200)_1px,transparent_1px)] bg-[length:16px_16px] px-6 py-8 dark:bg-[radial-gradient(var(--color-zinc-800)_1px,transparent_1px)]">
                        <nitro:dynamic-component :is="$block['component']" :key="$slug.'-'.$i" />
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Previous / next --}}
    <nav class="mt-16 grid gap-4 border-t border-zinc-200 pt-8 sm:grid-cols-2 dark:border-white/10">
        @if ($prev)
            <a nitro:navigate href="/docs/{{ $prev['slug'] }}" rel="prev" class="group rounded-xl p-4 ring-1 ring-zinc-200 transition hover:ring-zinc-300 dark:ring-white/10 dark:hover:ring-white/20">
                <span class="text-xs text-zinc-500">← Previous</span>
                <span class="mt-1 block font-semibold text-zinc-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">{{ $prev['title'] }}</span>
            </a>
        @endif
        @if ($next)
            <a nitro:navigate href="/docs/{{ $next['slug'] }}" rel="next" class="group rounded-xl p-4 text-right ring-1 ring-zinc-200 transition hover:ring-zinc-300 sm:col-start-2 dark:ring-white/10 dark:hover:ring-white/20">
                <span class="text-xs text-zinc-500">Next →</span>
                <span class="mt-1 block font-semibold text-zinc-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">{{ $next['title'] }}</span>
            </a>
        @endif
    </nav>
    <div class="mt-8 flex flex-wrap items-center justify-between gap-3 text-xs text-zinc-500">
        <a href="https://github.com/ZeeshanX4/nitro-fusion" class="inline-flex items-center gap-1.5 hover:text-zinc-900 dark:hover:text-white">
            <svg class="size-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.5 2.5 13.5 5.5 6 13H3v-3l7.5-7.5Z" stroke-linejoin="round"/></svg>
            Edit this page on GitHub
        </a>
    </div>
</article>

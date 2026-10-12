<x-layouts.site full-footer>
<div class="home-page">
    {{-- Hero --}}
    <section class="relative isolate overflow-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -top-40 left-[10%] h-[28rem] w-[28rem] rounded-full bg-amber-300/25 blur-3xl dark:bg-amber-500/10"></div>
            <div class="absolute -top-24 right-[8%] h-[30rem] w-[30rem] rounded-full bg-sky-400/25 blur-3xl dark:bg-blue-600/20"></div>
            <div class="absolute top-48 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-blue-400/15 blur-3xl dark:bg-sky-500/10"></div>

            {{-- The veins: faint straight lines across the hero, and Nitro's colours running along them --}}
            <svg class="veins absolute top-0 left-1/2 h-[680px] w-[1800px] -translate-x-1/2 [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]" viewBox="0 0 1800 680" fill="none">
                @php
                    $veins = [
                        ['M-50 60L1850 60', '#38bdf8', '0s', '8s'],
                        ['M-50 620L1850 620', '#fbbf24', '2s', '9s'],
                        ['M1510 230L1850 150', '#38bdf8', '.6s', '4.5s'],
                        ['M1510 410L1850 490', '#fbbf24', '2.6s', '5s'],
                        ['M260 210L-50 140', '#fbbf24', '1.4s', '4.5s'],
                        ['M260 440L-50 520', '#3b82f6', '3.4s', '5s'],
                    ];
                @endphp
                @foreach ($veins as [$path])
                    <path d="{{ $path }}" class="stroke-slate-900/[0.07] dark:stroke-white/[0.06]" />
                @endforeach
                @foreach ($veins as [$path, $color, $delay, $time])
                    <path d="{{ $path }}" pathLength="1" stroke="{{ $color }}" stroke-width="1.5" class="vein" style="--vein-delay: {{ $delay }}; --vein-time: {{ $time }}" />
                @endforeach
            </svg>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,var(--color-slate-200)_1px,transparent_1px),linear-gradient(to_bottom,var(--color-slate-200)_1px,transparent_1px)] bg-[size:56px_56px] opacity-40 [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)] dark:bg-[linear-gradient(to_right,var(--color-slate-800)_1px,transparent_1px),linear-gradient(to_bottom,var(--color-slate-800)_1px,transparent_1px)]"></div>
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 pt-20 pb-16 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:px-8 lg:pt-28">
            <div>
                <a nitro:navigate href="/docs" class="inline-flex items-center gap-2 rounded-full bg-white/70 py-1 pr-3 pl-1 text-xs font-medium text-slate-700 ring-1 ring-slate-200 backdrop-blur hover:ring-slate-300 dark:bg-white/5 dark:text-slate-300 dark:ring-white/10">
                    <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold text-white nitro-gradient">New</span>
                    Nitro {{ config('docs.version') }}: browser-first components for Laravel
                    <svg class="size-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m4.5 3 3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <h1 class="mt-7 text-5xl font-bold tracking-tight text-balance text-slate-900 sm:text-6xl dark:text-white">
                    Write PHP.<br><span class="nitro-text">It runs in the browser.</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-pretty text-slate-600 dark:text-slate-400">
                    Nitro compiles your Laravel components, PHP classes and Blade views, to JavaScript.
                    Methods run instantly in the browser, with no request. Mark one <code class="rounded-md bg-server-500/10 px-1.5 py-0.5 font-mono text-[0.9em] text-server-700 dark:text-server-300">#[Server]</code> when it needs the server.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <a nitro:navigate href="/docs" class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-110 nitro-gradient">Get started</a>
                    <a href="{{ config('docs.github') }}" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:ring-white/20">GitHub</a>
                    <div class="code-frame flex items-center gap-3 rounded-xl bg-slate-900 py-2.5 pr-2.5 pl-4 font-mono text-[13px] text-slate-300 ring-1 ring-white/10 dark:bg-white/[0.04]" data-code="composer require nitro/nitro">
                        <span class="text-slate-500">$</span> composer require nitro/nitro
                        <button type="button" data-copy class="rounded-md p-1.5 text-slate-400 hover:bg-white/10 hover:text-white" aria-label="Copy">
                            <svg class="size-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5.25" y="5.25" width="8.5" height="8.5" rx="1.5"/><path d="M10.75 5.25v-2a1 1 0 0 0-1-1h-6.5a1 1 0 0 0-1 1v6.5a1 1 0 0 0 1 1h2"/></svg>
                            <span data-copy-label class="sr-only">Copy</span>
                        </button>
                    </div>
                </div>
                <x-home.view-logos class="mt-10" />
            </div>

            <x-home.mechanics />
        </div>

        {{-- Nitro in four numbers --}}
        <div class="mx-auto max-w-7xl px-6 pb-20 lg:px-8">
            <x-home.stats />
        </div>
    </section>

    {{-- The idea, in three: each opens its page --}}
    <section class="border-y border-slate-900/[0.06] bg-slate-50/60 dark:border-white/[0.06] dark:bg-white/[0.015]">
        <div class="mx-auto grid max-w-7xl gap-6 px-6 py-16 sm:grid-cols-3 lg:px-8">
            @foreach ([
                ['both', 'how-it-works', 'One component, two places', 'A PHP class and a Blade view. The server renders the first page with Blade; the browser runs the same component, compiled.', '<path d="M4 6h12M4 14h12" stroke-linecap="round"/><path d="m13 3 3 3-3 3M7 11l-3 3 3 3" stroke-linecap="round" stroke-linejoin="round"/>'],
                ['browser', 'methods', 'Methods run in the browser', 'Clicks, typing, filtering and sorting answer at once: your methods are JavaScript now, with PHP\'s rules kept.', '<rect x="2.75" y="3.75" width="14.5" height="12.5" rx="2"/><path d="M2.75 7.25h14.5" stroke-linecap="round"/>'],
                ['server', 'server-methods', '#[Server] when it matters', 'The database, mail, payments. One attribute, and the call carries the signed state to the server and back.', '<rect x="3.75" y="3.25" width="12.5" height="5.5" rx="1.5"/><rect x="3.75" y="11.25" width="12.5" height="5.5" rx="1.5"/><path d="M6.75 6h.01M6.75 14h.01" stroke-linecap="round" stroke-width="2"/>'],
            ] as [$runs, $page, $title, $text, $icon])
                <a nitro:navigate href="/docs/{{ $page }}" class="group rounded-2xl p-6 ring-1 ring-transparent transition hover:bg-white hover:ring-slate-200 dark:hover:bg-white/[0.03] dark:hover:ring-white/10">
                    <div class="flex items-center gap-3">
                        <span @class([
                            'flex size-9 items-center justify-center rounded-xl ring-1',
                            'bg-browser-500/10 text-browser-600 ring-browser-500/20 dark:text-browser-400' => $runs === 'browser',
                            'bg-server-500/10 text-server-600 ring-server-500/20 dark:text-server-400' => $runs === 'server',
                            'bg-sky-500/10 text-sky-600 ring-sky-500/20 dark:text-sky-400' => $runs === 'both',
                        ])><svg class="size-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">{!! $icon !!}</svg></span>
                        <x-docs.badge :runs="$runs" />
                    </div>
                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900 dark:text-white">{{ $title }} <span class="inline-block opacity-0 transition group-hover:translate-x-0.5 group-hover:opacity-100">→</span></h2>
                    <p class="mt-2 text-[15px] leading-7 text-slate-600 dark:text-slate-400">{{ $text }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- The features, each running --}}
    <section class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8">
        <span class="vein-scroll pointer-events-none absolute inset-y-0 -left-px w-px bg-gradient-to-b from-amber-400 via-sky-400 to-blue-600" aria-hidden="true"></span>
        <span class="vein-scroll pointer-events-none absolute inset-y-0 -right-px w-px bg-gradient-to-b from-amber-400 via-sky-400 to-blue-600" aria-hidden="true"></span>
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold"><span class="nitro-text">Everything an app needs, the Laravel way</span></p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">Try it right here</h2>
            <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-400">Each example below is a Nitro component, running on this page.</p>
        </div>

        <div class="mt-20 space-y-24 lg:space-y-32">
            <x-home.feature eyebrow="Search" title="Filtered as you type, kept in the URL" runs="browser">
                Typing filters the list in the browser, with no request. <code>#[Url(as: 'q')]</code> keeps the
                search in the address, so a refresh or a shared link shows the same results. Try a word like "forms".
                <x-slot:code>
                    <x-docs.tabs class="!my-0 !rounded-none !ring-0 !bg-transparent">
                        <x-docs.tab label="PostSearch.php"><x-docs.code src="home-search.php" highlight="3,13,14,15,16,17" bare /></x-docs.tab>
                        <x-docs.tab label="post-search.blade.php"><x-docs.code src="home-search.blade.php" lang="blade" highlight="2" bare /></x-docs.tab>
                    </x-docs.tabs>
                </x-slot:code>
                <x-slot:demo><nitro:post-search /></x-slot:demo>
            </x-home.feature>

            <x-home.feature eyebrow="Forms" title="Laravel's validation, as you know it" runs="both" flip url="app.test/newsletter">
                The rules sit on the property. The server checks them before your method runs, and the message
                lands in <code>@@error</code>. <code>nitro:loading</code> covers the wait. Try a wrong address, then a right one.
                <x-slot:code>
                    <x-docs.tabs class="!my-0 !rounded-none !ring-0 !bg-transparent">
                        <x-docs.tab label="Subscribe.php"><x-docs.code src="home-subscribe.php" highlight="1,4" bare /></x-docs.tab>
                        <x-docs.tab label="subscribe.blade.php"><x-docs.code src="home-subscribe.blade.php" lang="blade" bare /></x-docs.tab>
                    </x-docs.tabs>
                </x-slot:code>
                <x-slot:demo><nitro:subscribe /></x-slot:demo>
            </x-home.feature>

            <x-home.feature eyebrow="Uploads" title="Files, previewed at once" runs="both" url="app.test/profile">
                Bind a file input like any other. The browser shows the preview before anything is saved; the
                upload, the rules and the storage stay on the server.
                <x-slot:code>
                    <x-docs.tabs class="!my-0 !rounded-none !ring-0 !bg-transparent">
                        <x-docs.tab label="Photo.php"><x-docs.code src="home-upload.php" highlight="1,8" bare /></x-docs.tab>
                        <x-docs.tab label="photo.blade.php"><x-docs.code src="home-upload.blade.php" lang="blade" bare /></x-docs.tab>
                    </x-docs.tabs>
                </x-slot:code>
                <x-slot:demo><nitro:photo-check /></x-slot:demo>
            </x-home.feature>

            <x-home.feature eyebrow="Navigation" title="Pages without a reload" runs="browser" flip url="app.test/posts">
                <code>nitro:navigate</code> swaps the page in place and keeps back and forward working.
                <code>nitro:prefetch</code> loads it when the pointer comes near, so the click is instant.
                <x-slot:code>
                    <x-docs.tabs class="!my-0 !rounded-none !ring-0 !bg-transparent">
                        <x-docs.tab label="posts.blade.php"><x-docs.code src="home-navigate.blade.php" lang="blade" bare /></x-docs.tab>
                    </x-docs.tabs>
                </x-slot:code>
                <x-slot:demo>
                    <a nitro:navigate nitro:prefetch href="/docs/navigation" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">
                        Open the navigation docs
                        <svg class="size-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m4.5 3 3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </x-slot:demo>
            </x-home.feature>
        </div>
    </section>

    {{-- Requests, by design --}}
    <section class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-24 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:px-8">
            <div>
                <p class="text-sm font-semibold"><span class="nitro-text">Browser-first</span></p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">The server, only when it's needed</h2>
                <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-400">
                    Where every click and keystroke goes to the server, each one waits on the network. In Nitro your
                    methods run in the browser, so they answer at once, and the server hears from the page when a
                    <code class="rounded-md bg-server-500/10 px-1.5 py-0.5 font-mono text-[0.9em] text-server-700 dark:text-server-300">#[Server]</code> method needs it.
                </p>
                <a nitro:navigate href="/docs/how-it-works" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-500 dark:text-sky-400">How Nitro works <span aria-hidden="true">→</span></a>
            </div>
            <x-home.requests />
        </div>
    </section>

    {{-- What the browser runs --}}
    <section class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto max-w-5xl px-6 py-24 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold"><span class="nitro-text">No magic, just a compiler</span></p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">See exactly what runs where</h2>
                <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-400">The class and the view are yours. Open <strong class="font-semibold text-slate-900 dark:text-white">Compiled</strong> to read the JavaScript Nitro makes of them: the same component, the same rules.</p>
            </div>
            <x-docs.pair class="app/Nitro/Components/Counter.php" view="resources/views/nitro/components/counter.blade.php" component="counter" />
            <div class="flex items-center justify-center gap-3">
                <span class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400"><span class="size-1.5 animate-pulse rounded-full bg-emerald-500"></span> Live</span>
                <nitro:counter />
            </div>
        </div>
    </section>

    {{-- And more --}}
    <section class="border-t border-slate-900/[0.06] bg-slate-50/60 dark:border-white/[0.06] dark:bg-white/[0.015]">
        <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">
            <h2 class="max-w-xl text-3xl font-bold tracking-tight text-slate-900 dark:text-white">And the rest of an app</h2>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['pages', 'Pages and layouts', 'Route::nitro() pages with nested layouts, middleware and route model binding.', 'both'],
                    ['sharing-state', 'Stores', 'State shared between components: a cart badge and its drawer, kept in step.', 'browser'],
                    ['head', 'The page\'s head', 'Titles, descriptions and meta tags per page, updated as you navigate.', 'both'],
                    ['security', 'Signed state', 'Locked properties, typed updates, the page\'s middleware checked again on every call.', 'server'],
                    ['transitions', 'Transitions and islands', 'Enter and leave transitions, and parts of a page that start only when needed.', 'browser'],
                    ['views', 'Blade, or your framework', 'Write the view in Blade, or in Vue, React, Solid or Svelte: the same PHP class behind it.', 'browser'],
                ] as [$page, $title, $text, $runs])
                    <a nitro:navigate href="/docs/{{ $page }}" class="group rounded-2xl bg-white p-6 ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-900/[0.04] hover:ring-slate-300 dark:bg-white/[0.02] dark:ring-white/10 dark:hover:ring-white/20">
                        <x-docs.badge :runs="$runs" />
                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">{{ $title }} <span class="inline-block transition group-hover:translate-x-0.5">→</span></h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $text }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Call to action --}}
    <section class="px-6 py-24 lg:px-8">
        <div class="relative mx-auto max-w-5xl overflow-hidden rounded-3xl bg-slate-950 px-8 py-16 text-center ring-1 ring-white/10 sm:px-16">
            <div class="pointer-events-none absolute -top-24 left-1/2 h-64 w-[36rem] -translate-x-1/2 rounded-full opacity-40 blur-3xl nitro-gradient"></div>
            <h2 class="relative text-3xl font-bold tracking-tight text-white sm:text-4xl">Build your first component in five minutes</h2>
            <p class="relative mx-auto mt-4 max-w-xl text-lg leading-8 text-slate-400">Install the package, write a class and a view, and watch it run in the browser.</p>
            <div class="relative mt-9 flex justify-center gap-3">
                <a nitro:navigate href="/docs" class="rounded-xl px-5 py-3 text-sm font-semibold text-white transition hover:brightness-110 nitro-gradient">Read the docs</a>
                <a href="{{ config('docs.github') }}" class="rounded-xl bg-white/10 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/15 transition hover:bg-white/15">GitHub</a>
            </div>
        </div>
    </section>
</div>
</x-layouts.site>

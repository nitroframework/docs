<x-layouts.site>
    {{-- Hero --}}
    <section class="relative isolate overflow-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -top-40 left-[12%] h-[28rem] w-[28rem] rounded-full bg-amber-400/25 blur-3xl dark:bg-amber-500/15"></div>
            <div class="absolute -top-24 right-[8%] h-[30rem] w-[30rem] rounded-full bg-violet-500/25 blur-3xl dark:bg-violet-600/20"></div>
            <div class="absolute top-40 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-pink-400/20 blur-3xl dark:bg-pink-500/10"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,var(--color-zinc-200)_1px,transparent_1px),linear-gradient(to_bottom,var(--color-zinc-200)_1px,transparent_1px)] bg-[size:56px_56px] opacity-40 [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)] dark:bg-[linear-gradient(to_right,var(--color-zinc-800)_1px,transparent_1px),linear-gradient(to_bottom,var(--color-zinc-800)_1px,transparent_1px)]"></div>
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 pt-20 pb-24 lg:grid-cols-[1.05fr_1fr] lg:px-8 lg:pt-28">
            <div>
                <a nitro:navigate href="/docs" class="inline-flex items-center gap-2 rounded-full bg-white/70 py-1 pr-3 pl-1 text-xs font-medium text-zinc-700 ring-1 ring-zinc-200 backdrop-blur hover:ring-zinc-300 dark:bg-white/5 dark:text-zinc-300 dark:ring-white/10">
                    <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold text-white nitro-gradient">New</span>
                    Nitro {{ config('docs.version') }}: browser-first components for Laravel
                    <svg class="size-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m4.5 3 3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <h1 class="mt-7 text-5xl font-bold tracking-tight text-balance text-zinc-900 sm:text-6xl dark:text-white">
                    Write PHP.<br><span class="nitro-text">It runs in the browser.</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-pretty text-zinc-600 dark:text-zinc-400">
                    Nitro compiles your Laravel components, PHP classes and Blade views, to JavaScript.
                    Methods run instantly in the browser, with no request. Mark one <code class="rounded-md bg-server-500/10 px-1.5 py-0.5 font-mono text-[0.9em] text-server-700 dark:text-server-300">#[Server]</code> when it needs the server.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <a nitro:navigate href="/docs" class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-500/20 transition hover:brightness-110 nitro-gradient">Get started</a>
                    <a href="{{ config('docs.github') }}" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-zinc-900 ring-1 ring-zinc-200 transition hover:ring-zinc-300 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:ring-white/20">GitHub</a>
                    <div class="code-frame flex items-center gap-3 rounded-xl bg-zinc-900 py-2.5 pr-2.5 pl-4 font-mono text-[13px] text-zinc-300 ring-1 ring-white/10 dark:bg-white/[0.04]" data-code="composer require nitro/nitro">
                        <span class="text-zinc-500">$</span> composer require nitro/nitro
                        <button type="button" data-copy class="rounded-md p-1.5 text-zinc-400 hover:bg-white/10 hover:text-white" aria-label="Copy">
                            <svg class="size-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5.25" y="5.25" width="8.5" height="8.5" rx="1.5"/><path d="M10.75 5.25v-2a1 1 0 0 0-1-1h-6.5a1 1 0 0 0-1 1v6.5a1 1 0 0 0 1 1h2"/></svg>
                            <span data-copy-label class="sr-only">Copy</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- The code card: a component, and the component running --}}
            <div class="relative">
                <div class="absolute -inset-px rounded-[1.35rem] opacity-60 blur-sm nitro-gradient"></div>
                <div class="relative overflow-hidden rounded-[1.3rem] bg-white shadow-2xl ring-1 ring-zinc-900/5 dark:bg-zinc-900 dark:ring-white/10">
                    <x-docs.tabs class="!my-0 !rounded-none !ring-0 !bg-transparent">
                        <x-docs.tab label="Counter.php"><x-docs.code src="app/Nitro/Components/Counter.php" bare /></x-docs.tab>
                        <x-docs.tab label="counter.blade.php"><x-docs.code src="resources/views/nitro/components/counter.blade.php" lang="blade" bare /></x-docs.tab>
                    </x-docs.tabs>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 border-t border-zinc-200/80 bg-zinc-50/80 px-5 py-4 dark:border-white/[0.07] dark:bg-white/[0.02]">
                        <span class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span> Live
                        </span>
                        <nitro:counter />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- The idea, in three --}}
    <section class="border-y border-zinc-900/[0.06] bg-zinc-50/60 dark:border-white/[0.06] dark:bg-white/[0.015]">
        <div class="mx-auto grid max-w-7xl gap-px px-6 py-20 sm:grid-cols-3 lg:px-8">
            @foreach ([
                ['both', 'One component, two places', 'A PHP class and a Blade view. The server renders the first page with Blade; the browser runs the same component, compiled.'],
                ['browser', 'Methods run in the browser', 'Clicks, typing, filtering and sorting answer at once: your methods are JavaScript now, with PHP\'s rules kept.'],
                ['server', '#[Server] when it matters', 'The database, mail, payments. One attribute, and the call carries the signed state to the server and back.'],
            ] as [$runs, $title, $text])
                <div class="px-0 py-6 sm:px-8 sm:first:pl-0">
                    <x-docs.badge :runs="$runs" />
                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h2>
                    <p class="mt-2 text-[15px] leading-7 text-zinc-600 dark:text-zinc-400">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- What the browser runs --}}
    <section class="mx-auto max-w-5xl px-6 py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold"><span class="nitro-text">No magic, just a compiler</span></p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl dark:text-white">See exactly what runs where</h2>
            <p class="mt-4 text-lg leading-8 text-zinc-600 dark:text-zinc-400">The class and the view are yours. Open <strong class="font-semibold text-zinc-900 dark:text-white">Compiled</strong> to read the JavaScript Nitro makes of them: the same component, the same rules.</p>
        </div>
        <x-docs.pair class="app/Nitro/Components/Counter.php" view="resources/views/nitro/components/counter.blade.php" component="counter" />
    </section>

    {{-- Features --}}
    <section class="border-t border-zinc-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">
            <h2 class="max-w-xl text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Everything an app needs, the Laravel way</h2>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['Pages and navigation', 'Route::nitro() pages, links that swap the page without a reload, back and forward kept.', 'browser'],
                    ['The page\'s head', 'Titles, descriptions and meta tags per page, updated as you navigate.', 'both'],
                    ['Forms and validation', 'nitro:model bindings and #[Validate] rules, checked before a server method runs.', 'both'],
                    ['Uploads', 'Files from a file input, previewed at once, validated and stored on the server.', 'server'],
                    ['Signed state', 'Locked properties, typed updates, the page\'s middleware checked again on every call.', 'server'],
                    ['Transitions and islands', 'Enter and leave transitions, and parts of a page that start only when needed.', 'browser'],
                ] as [$title, $text, $runs])
                    <div class="rounded-2xl p-6 ring-1 ring-zinc-200 transition hover:ring-zinc-300 dark:ring-white/10 dark:hover:ring-white/20">
                        <x-docs.badge :runs="$runs" />
                        <h3 class="mt-4 font-semibold text-zinc-900 dark:text-white">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-400">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Call to action --}}
    <section class="px-6 pb-24 lg:px-8">
        <div class="relative mx-auto max-w-5xl overflow-hidden rounded-3xl bg-zinc-950 px-8 py-16 text-center ring-1 ring-white/10 sm:px-16">
            <div class="pointer-events-none absolute -top-24 left-1/2 h-64 w-[36rem] -translate-x-1/2 rounded-full opacity-40 blur-3xl nitro-gradient"></div>
            <h2 class="relative text-3xl font-bold tracking-tight text-white sm:text-4xl">Build your first component in five minutes</h2>
            <p class="relative mx-auto mt-4 max-w-xl text-lg leading-8 text-zinc-400">Install the package, write a class and a view, and watch it run in the browser.</p>
            <div class="relative mt-9 flex justify-center gap-3">
                <a nitro:navigate href="/docs" class="rounded-xl px-5 py-3 text-sm font-semibold text-white transition hover:brightness-110 nitro-gradient">Read the docs</a>
                <a href="{{ config('docs.github') }}" class="rounded-xl bg-white/10 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/15 transition hover:bg-white/15">GitHub</a>
            </div>
        </div>
    </section>
</x-layouts.site>

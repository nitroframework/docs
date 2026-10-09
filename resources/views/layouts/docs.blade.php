<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <x-docs.head />
</head>
<body class="min-h-full">
    <x-docs.header drawer active="docs" />

    <div class="mx-auto flex max-w-[90rem] px-4 sm:px-6 lg:px-8">
        {{-- Sidebar (a drawer on small screens); nitro:current marks the page's link, on every visit. --}}
        <div data-drawer-backdrop class="fixed inset-0 z-40 hidden bg-zinc-950/40 backdrop-blur-sm lg:hidden"></div>
        <aside data-drawer class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full overflow-y-auto bg-white px-5 pt-5 pb-10 shadow-xl transition-transform duration-200 lg:sticky lg:top-16 lg:z-0 lg:h-[calc(100dvh-4rem)] lg:w-64 lg:shrink-0 lg:translate-x-0 lg:bg-transparent lg:px-0 lg:pt-8 lg:pr-6 lg:shadow-none dark:bg-zinc-950 lg:dark:bg-transparent">
            <div class="mb-6 flex items-center justify-between lg:hidden">
                <x-docs.logo />
                <button type="button" data-drawer-close class="rounded-md p-1.5 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5" aria-label="Close navigation">
                    <svg class="size-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>
                </button>
            </div>
            <nav class="space-y-7 text-sm">
                @foreach (config('docs.nav') as $group => $pages)
                    <div>
                        <h3 class="mb-2 text-xs font-semibold tracking-wide text-zinc-900 dark:text-white">{{ $group }}</h3>
                        <ul class="space-y-0.5 border-l border-zinc-200 dark:border-white/[0.07]">
                            @foreach ($pages as $pageSlug => $label)
                                <li>
                                    <a nitro:navigate nitro:current.exact="sidebar-current" href="{{ \App\Docs\Nav::url($pageSlug) }}" @class([
                                        'sidebar-link relative block py-1.5 pl-4 text-zinc-600 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white',
                                        'sidebar-current' => request()->is(ltrim(\App\Docs\Nav::url($pageSlug), '/')),
                                    ])>{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </aside>

        {{-- Content: the docs page (App\Nitro\Pages\Docs\Show) --}}
        <main class="min-w-0 flex-1 py-10 lg:px-10 xl:px-14">
            {{ $slot }}
        </main>

        {{-- On this page (filled by resources/js/app.js) --}}
        <aside class="sticky top-16 hidden h-[calc(100dvh-4rem)] w-56 shrink-0 overflow-y-auto py-10 xl:block">
            <p class="mb-3 pl-3 text-xs font-semibold tracking-wide text-zinc-900 dark:text-white">On this page</p>
            <nav data-toc class="pl-3 text-sm"></nav>
        </aside>
    </div>

    <x-docs.search />

    @nitroScripts
</body>
</html>

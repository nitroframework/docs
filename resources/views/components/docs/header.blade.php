@props(['drawer' => false, 'active' => null])

<header class="sticky top-0 z-40 border-b border-slate-900/[0.06] bg-white/80 backdrop-blur-lg supports-[backdrop-filter]:bg-white/70 dark:border-white/[0.06] dark:bg-ink/75">
    <div class="mx-auto flex h-16 max-w-[90rem] items-center gap-4 px-4 sm:px-6 lg:px-8">
        @if ($drawer)
            <button type="button" data-drawer-open class="-ml-1 rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900 lg:hidden dark:hover:bg-white/5 dark:hover:text-white" aria-label="Open navigation">
                <svg class="size-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 5.5h14M3 10h14M3 14.5h14" stroke-linecap="round"/></svg>
            </button>
        @endif
        <a nitro:navigate href="/" class="shrink-0" aria-label="Nitro home"><x-docs.logo /></a>
        <button type="button" class="hidden items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 hover:ring-slate-300 sm:flex dark:text-slate-400 dark:ring-white/10 dark:hover:ring-white/20">
            v{{ config('docs.version') }}
            <svg class="size-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 4.5 3 3 3-3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        <button type="button" data-search-open class="mx-auto flex h-9 w-full max-w-sm items-center gap-2.5 rounded-lg bg-slate-50 px-3 text-sm text-slate-500 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:bg-white/[0.04] dark:text-slate-400 dark:ring-white/10 dark:hover:ring-white/20">
            <svg class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="9" r="5.75"/><path d="m13.5 13.5 3.5 3.5" stroke-linecap="round"/></svg>
            <span>Search docs…</span>
            <span class="ml-auto hidden items-center gap-0.5 sm:flex"><x-docs.kbd data-mod-key>⌘</x-docs.kbd><x-docs.kbd>K</x-docs.kbd></span>
        </button>

        <nav class="flex items-center gap-1">
            <a nitro:navigate nitro:prefetch href="/docs" @class(['hidden rounded-md px-2.5 py-1.5 text-sm font-medium md:block', 'text-slate-900 dark:text-white' => $active === 'docs', 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' => $active !== 'docs'])>Docs</a>
            <a href="{{ config('docs.github') }}" class="rounded-md p-2 text-slate-500 hover:text-slate-900 dark:hover:text-white" aria-label="GitHub">
                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.58 2 12.25c0 4.53 2.87 8.37 6.84 9.73.5.1.68-.22.68-.49l-.01-1.7c-2.78.62-3.37-1.37-3.37-1.37-.45-1.18-1.11-1.5-1.11-1.5-.91-.64.07-.62.07-.62 1 .07 1.53 1.06 1.53 1.06.9 1.56 2.35 1.11 2.92.85.09-.66.35-1.11.63-1.37-2.22-.26-4.56-1.14-4.56-5.07 0-1.12.39-2.04 1.03-2.76-.1-.26-.45-1.3.1-2.71 0 0 .84-.28 2.75 1.05a9.3 9.3 0 0 1 5 0c1.91-1.33 2.75-1.05 2.75-1.05.55 1.41.2 2.45.1 2.71.64.72 1.03 1.64 1.03 2.76 0 3.94-2.34 4.81-4.57 5.06.36.32.68.94.68 1.9l-.01 2.81c0 .27.18.6.69.49A10.25 10.25 0 0 0 22 12.25C22 6.58 17.52 2 12 2Z" clip-rule="evenodd"/></svg>
            </a>
            <div class="flex rounded-full p-0.5 ring-1 ring-slate-200 dark:ring-white/10" role="radiogroup" aria-label="Theme">
                @foreach ([
                    'light' => '<circle cx="10" cy="10" r="3.25"/><path d="M10 2.75v1.5M10 15.75v1.5M17.25 10h-1.5M4.25 10h-1.5M15.1 4.9l-1.06 1.06M5.96 14.04 4.9 15.1M15.1 15.1l-1.06-1.06M5.96 5.96 4.9 4.9" stroke-linecap="round"/>',
                    'system' => '<rect x="3" y="4" width="14" height="9.5" rx="1.5"/><path d="M7.5 16.5h5M10 13.5v3" stroke-linecap="round"/>',
                    'dark' => '<path d="M16.25 12.1A6.75 6.75 0 0 1 7.9 3.75a6.75 6.75 0 1 0 8.35 8.35Z" stroke-linejoin="round"/>',
                ] as $mode => $icon)
                    <button type="button" data-theme-set="{{ $mode }}" role="radio" aria-label="{{ ucfirst($mode) }} theme" class="theme-option rounded-full p-1 text-slate-400 transition hover:text-slate-900 dark:hover:text-white">
                        <svg class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">{!! $icon !!}</svg>
                    </button>
                @endforeach
            </div>
        </nav>
    </div>
</header>

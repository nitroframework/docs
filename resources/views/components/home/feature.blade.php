@props(['eyebrow', 'title', 'runs', 'code', 'demo' => null, 'url' => null])

{{--
    A homepage feature: what it is above, then its code and the component running, side by side.
    url: the demo in a browser frame with that address (a demo with its own frame gives none).
--}}
<div>
    <div class="mx-auto max-w-2xl text-center">
        <div class="flex items-center justify-center gap-3">
            <p class="text-sm font-semibold"><span class="nitro-text">{{ $eyebrow }}</span></p>
            <x-docs.badge :runs="$runs" />
        </div>
        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">{{ $title }}</h3>
        <p class="mt-4 text-base leading-7 text-slate-600 dark:text-slate-400">{{ $slot }}</p>
    </div>
    <div class="mt-10 grid min-w-0 overflow-hidden rounded-2xl bg-white shadow-xl shadow-slate-900/[0.04] ring-1 ring-slate-200 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] dark:bg-slate-900 dark:shadow-none dark:ring-white/10">
        <div class="min-w-0 lg:border-r lg:border-slate-200/80 dark:lg:border-white/[0.07]">{{ $code }}</div>
        @if ($demo)
            <div class="flex min-w-0 flex-col border-t border-slate-200/80 bg-slate-50/80 lg:border-t-0 dark:border-white/[0.07] dark:bg-white/[0.02]">
                <div class="flex items-center justify-between px-5 pt-4">
                    <span class="flex shrink-0 items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400"><span class="size-1.5 animate-pulse rounded-full bg-emerald-500"></span> Live</span>
                    <span class="text-xs text-slate-400">running on this page</span>
                </div>
                <div class="flex flex-1 items-center p-5">
                    <div class="w-full">
                        @if ($url)
                            <x-home.browser :url="$url">{{ $demo }}</x-home.browser>
                        @else
                            {{ $demo }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

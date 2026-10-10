@props(['eyebrow', 'title', 'runs', 'code', 'demo' => null, 'flip' => false])

{{-- A homepage feature: what it is and its code on one side, the component running on the other. --}}
<div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
    <div @class(['lg:order-2' => $flip])>
        <div class="flex items-center gap-3">
            <p class="text-sm font-semibold"><span class="nitro-text">{{ $eyebrow }}</span></p>
            <x-docs.badge :runs="$runs" />
        </div>
        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">{{ $title }}</h3>
        <p class="mt-4 text-base leading-7 text-slate-600 dark:text-slate-400">{{ $slot }}</p>
    </div>
    <div class="min-w-0 overflow-hidden rounded-2xl bg-white shadow-xl shadow-slate-900/[0.04] ring-1 ring-slate-200 dark:bg-slate-900 dark:shadow-none dark:ring-white/10">
        <div class="min-w-0">{{ $code }}</div>
        @if ($demo)
            <div class="flex items-center gap-4 border-t border-slate-200/80 bg-slate-50/80 px-5 py-5 dark:border-white/[0.07] dark:bg-white/[0.02]">
                <span class="flex shrink-0 items-center gap-1.5 self-start pt-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <span class="size-1.5 animate-pulse rounded-full bg-emerald-500"></span> Live
                </span>
                <div class="min-w-0 flex-1">{{ $demo }}</div>
            </div>
        @endif
    </div>
</div>

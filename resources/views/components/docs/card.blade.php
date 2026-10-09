@props(['href' => '#', 'title', 'icon' => 'arrow', 'runs' => null])

@php
    $icons = [
        'arrow' => '<path d="M4 10h11m0 0-4-4m4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>',
        'server' => '<rect x="3" y="3.5" width="14" height="5" rx="1.5"/><rect x="3" y="11.5" width="14" height="5" rx="1.5"/><path d="M6 6h.01M6 14h.01" stroke-linecap="round" stroke-width="2"/>',
        'browser' => '<rect x="2.75" y="3.75" width="14.5" height="12.5" rx="2"/><path d="M2.75 7.25h14.5M5.5 5.5h.01M7.5 5.5h.01" stroke-linecap="round"/>',
        'book' => '<path d="M10 5.5c-1.5-1.2-3.6-1.75-6.25-1.75v11.5c2.65 0 4.75.55 6.25 1.75m0-11.5c1.5-1.2 3.6-1.75 6.25-1.75v11.5c-2.65 0-4.75.55-6.25 1.75m0-11.5v11.5" stroke-linejoin="round"/>',
        'bolt' => '<path d="M11 2.75 4.5 11h5l-1 6.25L15.5 9h-5l.5-6.25Z" stroke-linejoin="round"/>',
    ];
@endphp

<a nitro:navigate href="{{ $href }}" {{ $attributes->class('group relative flex gap-4 rounded-xl p-4 ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:ring-zinc-300 dark:ring-white/10 dark:hover:bg-white/[0.03] dark:hover:ring-white/20') }}>
    <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-zinc-200 transition group-hover:ring-browser-300 dark:bg-white/5 dark:ring-white/10 dark:group-hover:ring-browser-400/40">
        <svg class="size-5 text-zinc-600 transition group-hover:text-browser-600 dark:text-zinc-300 dark:group-hover:text-browser-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">{!! $icons[$icon] ?? $icons['arrow'] !!}</svg>
    </span>
    <span class="min-w-0">
        <span class="flex items-center gap-2 text-[15px] font-semibold text-zinc-900 dark:text-white">
            {{ $title }}
            @if ($runs)<x-docs.badge :runs="$runs" />@endif
        </span>
        <span class="mt-1 block text-sm leading-6 text-zinc-600 dark:text-zinc-400">{{ $slot }}</span>
    </span>
</a>

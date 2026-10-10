@props(['type' => 'note', 'title' => null])

@php
    $styles = [
        'note' => ['bg-slate-50 ring-slate-200 dark:bg-white/[0.03] dark:ring-white/10', 'text-slate-500 dark:text-slate-400',
            '<circle cx="10" cy="10" r="7.25"/><path d="M10 9v4.5M10 6.5v.01" stroke-linecap="round"/>'],
        'tip' => ['bg-browser-50/70 ring-browser-200/70 dark:bg-browser-500/[0.07] dark:ring-browser-400/20', 'text-browser-600 dark:text-browser-400',
            '<path d="M7.5 15.5h5M8 13c-1.6-1-2.75-2.6-2.75-4.5a4.75 4.75 0 0 1 9.5 0c0 1.9-1.15 3.5-2.75 4.5v.75H8V13Z" stroke-linejoin="round"/>'],
        'warning' => ['bg-server-50/80 ring-server-200/80 dark:bg-server-500/[0.07] dark:ring-server-400/20', 'text-server-600 dark:text-server-400',
            '<path d="M8.6 3.4a1.6 1.6 0 0 1 2.8 0l6 10.6A1.6 1.6 0 0 1 16 16.4H4a1.6 1.6 0 0 1-1.4-2.4l6-10.6Z" stroke-linejoin="round"/><path d="M10 7.5v3.5M10 13.5v.01" stroke-linecap="round"/>'],
        'danger' => ['bg-rose-50/80 ring-rose-200/80 dark:bg-rose-500/[0.07] dark:ring-rose-400/20', 'text-rose-600 dark:text-rose-400',
            '<circle cx="10" cy="10" r="7.25"/><path d="m7.5 7.5 5 5m0-5-5 5" stroke-linecap="round"/>'],
    ];
    [$frame, $icon, $path] = $styles[$type] ?? $styles['note'];
@endphp

<div {{ $attributes->class(['my-6 flex gap-3 rounded-xl px-4 py-3.5 ring-1 ring-inset', $frame]) }} role="note">
    <svg class="mt-0.5 size-5 shrink-0 {{ $icon }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">{!! $path !!}</svg>
    <div class="min-w-0 text-[14.5px] leading-6 [&>p]:my-0 [&>p+p]:mt-2">
        @if ($title)
            <p class="font-semibold text-slate-900 dark:text-white">{{ $title }}</p>
        @endif
        {{ $slot }}
    </div>
</div>

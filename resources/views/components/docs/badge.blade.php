@props(['runs' => null, 'label' => null])

@php
    $styles = [
        'browser' => ['Browser', 'bg-browser-500/10 text-browser-700 ring-browser-500/20 dark:text-browser-300 dark:ring-browser-400/25', 'bg-browser-500'],
        'server' => ['Server', 'bg-server-500/10 text-server-700 ring-server-500/25 dark:text-server-300 dark:ring-server-400/25', 'bg-server-500'],
        'both' => ['Browser + server', 'bg-pink-500/10 text-pink-700 ring-pink-500/20 dark:text-pink-300 dark:ring-pink-400/25', 'nitro-gradient'],
        'since' => [$label, 'bg-slate-100 text-slate-600 ring-slate-200 dark:bg-white/5 dark:text-slate-400 dark:ring-white/10', null],
        'experimental' => ['Experimental', 'bg-sky-500/10 text-sky-700 ring-sky-500/20 dark:text-sky-300 dark:ring-sky-400/25', null],
    ];
    [$text, $class, $dot] = $styles[$runs] ?? $styles['since'];
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-[11px] leading-4 font-semibold ring-1 ring-inset whitespace-nowrap', $class]) }}>
    @if ($dot)<span class="size-1.5 rounded-full {{ $dot }}"></span>@endif
    {{ $label ?? $text }}
</span>

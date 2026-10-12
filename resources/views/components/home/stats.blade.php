{{-- Nitro in four numbers; the runtime's size is worked out from the installed package, so it stays true. --}}
@php
    $runtime = (int) round(strlen(gzencode((string) @file_get_contents(base_path('vendor/nitro/nitro/dist/nitro.js')), 9)) / 1024);

    $stats = [
        ['0', 'requests', 'for a browser method: a click, a keystroke, a filter', '/docs/methods'],
        ['1', 'PHP class', 'rendered by the server, run in the browser', '/docs/how-it-works'],
        ['5', 'ways to write a view', 'Blade, Vue, React, Solid or Svelte, one PHP class', '/docs/views'],
        [$runtime.' KB', 'runtime', 'gzipped, loaded once for every page', '/docs/production'],
    ];
@endphp

<div {{ $attributes->class('grid grid-cols-2 gap-px overflow-hidden rounded-2xl bg-slate-200/70 ring-1 ring-slate-200 lg:grid-cols-4 dark:bg-white/[0.06] dark:ring-white/10') }}>
    @foreach ($stats as [$value, $unit, $text, $href])
        <a nitro:navigate href="{{ $href }}" class="group bg-white px-6 py-6 transition hover:bg-slate-50 dark:bg-slate-950/80 dark:hover:bg-slate-900">
            <p class="flex items-baseline gap-2">
                <span class="text-3xl font-bold tracking-tight text-slate-900 tabular-nums dark:text-white">{{ $value }}</span>
                <span class="text-sm font-semibold"><span class="nitro-text">{{ $unit }}</span></span>
            </p>
            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $text }} <span class="inline-block opacity-0 transition group-hover:translate-x-0.5 group-hover:opacity-100">→</span></p>
        </a>
    @endforeach
</div>

@props(['src' => null, 'code' => null, 'lang' => 'php', 'file' => null, 'runs' => null, 'highlight' => '', 'added' => '', 'removed' => '', 'bare' => false])

@php
    $code ??= \App\Docs\Code::snippet($src);
    $lines = fn (string $list) => array_values(array_filter(array_map('intval', explode(',', $list))));
    $html = \App\Docs\Code::html($code, $lang, $lines($highlight), $lines($added), $lines($removed));
    $languages = ['php' => 'PHP', 'blade' => 'Blade', 'js' => 'JavaScript', 'vue' => 'Vue', 'svelte' => 'Svelte', 'jsx' => 'JSX', 'sh' => 'Terminal', 'json' => 'JSON', 'html' => 'HTML', 'css' => 'CSS', 'ini' => 'INI'];
@endphp

<div {{ $attributes->class(['code-frame group/code relative not-prose', 'my-6 overflow-hidden rounded-xl bg-slate-50/80 ring-1 ring-slate-200 dark:bg-slate-900/70 dark:ring-white/10' => ! $bare]) }} data-code="{{ $code }}">
    @unless ($bare)
        <div class="flex h-10 items-center gap-2 border-b border-slate-200/80 px-4 dark:border-white/[0.07]">
            @if ($lang === 'sh')
                <svg class="size-3.5 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m3 4 4 4-4 4M8.5 12h4.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @else
                <svg class="size-3.5 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 1.75H4.75a1 1 0 0 0-1 1v10.5a1 1 0 0 0 1 1h6.5a1 1 0 0 0 1-1V4.75L9 1.75Z" stroke-linejoin="round"/><path d="M9 1.75v3h3.25" stroke-linejoin="round"/></svg>
            @endif
            <span class="font-mono text-xs text-slate-600 dark:text-slate-400">{{ $file ?? ($languages[$lang] ?? strtoupper($lang)) }}</span>
            @if ($runs)
                <x-docs.badge :runs="$runs" class="ml-1" />
            @endif
            <button type="button" data-copy class="ml-auto flex items-center gap-1.5 rounded-md px-2 py-1 text-xs font-medium text-slate-500 opacity-0 transition group-hover/code:opacity-100 hover:bg-slate-200/60 hover:text-slate-900 focus:opacity-100 dark:hover:bg-white/10 dark:hover:text-white">
                <svg class="size-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5.25" y="5.25" width="8.5" height="8.5" rx="1.5"/><path d="M10.75 5.25v-2a1 1 0 0 0-1-1h-6.5a1 1 0 0 0-1 1v6.5a1 1 0 0 0 1 1h2"/></svg>
                <span data-copy-label>Copy</span>
            </button>
        </div>
    @endunless
    {!! $html !!}
</div>

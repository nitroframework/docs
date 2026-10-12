@php
    $path = '/'.ltrim(request()->path(), '/');
    $suggestion = str_starts_with($path, '/docs/') ? \App\Docs\Nav::closest(substr($path, 6)) : null;
@endphp

<x-layouts.site title="Page not found · Nitro">
    <x-docs.error code="404" title="This page isn't here">
        <p>
            There's nothing at <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-[13px] text-slate-800 dark:bg-white/10 dark:text-slate-200">{{ $path }}</code>.
            @if ($suggestion)
                Did you mean
                <a nitro:navigate href="{{ \App\Docs\Nav::url($suggestion['slug']) }}" class="font-medium text-blue-600 underline decoration-blue-600/30 underline-offset-4 hover:decoration-blue-600 dark:text-sky-400 dark:decoration-sky-400/30">{{ $suggestion['title'] }}</a>?
            @else
                The link may have a typo, or the page may have moved.
            @endif
        </p>

        <x-slot:actions>
            <a nitro:navigate href="/docs" class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-110 nitro-gradient">Read the docs</a>
            <button type="button" data-search-open class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:ring-white/20">Search the docs</button>
            <a nitro:navigate href="/" class="px-3 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Home</a>
        </x-slot:actions>
    </x-docs.error>
</x-layouts.site>

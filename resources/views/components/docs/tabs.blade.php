{{-- Tabs over code blocks (Laravel / Nitro, macOS / Windows / Linux): each child <x-docs.tab label="..."> is a panel. --}}
<div {{ $attributes->class('not-prose my-6 overflow-hidden rounded-xl bg-slate-50/80 ring-1 ring-slate-200 dark:bg-slate-900/70 dark:ring-white/10') }} data-tabs>
    <div class="flex items-center gap-1 border-b border-slate-200/80 px-2 dark:border-white/[0.07]" role="tablist" data-tabs-list></div>
    {{ $slot }}
</div>

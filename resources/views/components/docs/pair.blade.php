@props(['class', 'view', 'component' => null])

@php
    /** $component is Blade's own (the component) when the prop is not given: only a name counts. */
    $compiled = is_string($component) ? $component : null;
    $classFile = basename($class);
    $viewFile = basename($view);
@endphp

{{-- A component's class and its view, one at a time: tabs switch between them. --}}
<div class="not-prose my-8 overflow-hidden rounded-2xl bg-slate-50/80 ring-1 ring-slate-200 dark:bg-slate-900/70 dark:ring-white/10" data-pair>
    <div class="flex items-center gap-1 border-b border-slate-200/80 px-2 dark:border-white/[0.07]" role="tablist">
        <button type="button" role="tab" data-pair-tab="class" class="pair-tab is-active">{{ $classFile }}</button>
        <button type="button" role="tab" data-pair-tab="view" class="pair-tab">{{ $viewFile }}</button>
        <x-docs.badge runs="both" class="mr-2 ml-auto" />
    </div>
    <div data-pair-panel="class" role="tabpanel" class="min-w-0">
        <x-docs.code :src="$class" lang="php" bare />
    </div>
    <div data-pair-panel="view" role="tabpanel" class="hidden min-w-0">
        <x-docs.code :src="$view" lang="blade" bare />
    </div>
    @if ($compiled)
        <div class="border-t border-slate-200/80 dark:border-white/[0.07]">
            <button type="button" data-compiled-toggle aria-expanded="false" class="group/c flex w-full items-center gap-2.5 px-4 py-2.5 text-left text-xs font-medium text-slate-600 transition hover:bg-slate-100/70 dark:text-slate-400 dark:hover:bg-white/[0.03]">
                <svg class="size-3.5 transition group-aria-expanded/c:rotate-90" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75"><path d="m6 4 4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Compiled</span>
                <span class="text-slate-400 dark:text-slate-500">what the browser runs, from Nitro's compiler</span>
                <x-docs.badge runs="browser" class="ml-auto" />
            </button>
            {{-- Filled from /docs/compiled/{component} the first time it opens (resources/js/app.js). --}}
            <div data-compiled="{{ $compiled }}" hidden class="max-h-96 overflow-auto border-t border-dashed border-slate-200 bg-white/60 dark:border-white/10 dark:bg-black/20">
                <p class="px-5 py-4 text-xs text-slate-500">Compiling…</p>
            </div>
        </div>
    @endif
</div>

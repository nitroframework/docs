@props(['class', 'view', 'component' => null])

@php
    $compiled = $component ? \App\Docs\Code::compiled($component) : null;
    $classFile = basename($class);
    $viewFile = basename($view);
@endphp

{{-- A component's class and its view, one at a time: tabs switch between them. --}}
<div class="not-prose my-8 overflow-hidden rounded-2xl bg-zinc-50/80 ring-1 ring-zinc-200 dark:bg-zinc-900/70 dark:ring-white/10" data-pair>
    <div class="flex items-center gap-1 border-b border-zinc-200/80 px-2 dark:border-white/[0.07]" role="tablist">
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
        <div class="border-t border-zinc-200/80 dark:border-white/[0.07]">
            <button type="button" data-compiled-toggle aria-expanded="false" class="group/c flex w-full items-center gap-2.5 px-4 py-2.5 text-left text-xs font-medium text-zinc-600 transition hover:bg-zinc-100/70 dark:text-zinc-400 dark:hover:bg-white/[0.03]">
                <svg class="size-3.5 transition group-aria-expanded/c:rotate-90" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75"><path d="m6 4 4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Compiled</span>
                <span class="text-zinc-400 dark:text-zinc-500">what the browser runs, from Nitro's compiler</span>
                <x-docs.badge runs="browser" class="ml-auto" />
            </button>
            <div data-compiled hidden class="max-h-96 overflow-auto border-t border-dashed border-zinc-200 bg-white/60 dark:border-white/10 dark:bg-black/20">
                <x-docs.code :code="$compiled" lang="js" bare />
            </div>
        </div>
    @endif
</div>

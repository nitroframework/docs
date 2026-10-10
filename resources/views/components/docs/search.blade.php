{{-- Search (⌘K / Ctrl K): resources/js/app.js fills the results from /docs/search.json. --}}
<div data-search data-search-close-on="{{ config('docs.search.close', 'before') === 'after' ? 'after' : 'before' }}" hidden class="fixed inset-0 z-50">
    <div data-search-close class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-[12vh] w-[min(40rem,calc(100%-2rem))] overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10 dark:bg-slate-900 dark:ring-white/10">
        <div class="flex items-center gap-3 border-b border-slate-200 px-4 dark:border-white/10">
            <svg class="size-5 text-slate-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="9" r="5.75"/><path d="m13.5 13.5 3.5 3.5" stroke-linecap="round"/></svg>
            <input data-search-input type="search" autocomplete="off" spellcheck="false" aria-label="Search the docs" aria-controls="search-results" placeholder="Search the docs" class="h-14 flex-1 bg-transparent text-[15px] text-slate-900 outline-none placeholder:text-slate-400 dark:text-white">
            <x-docs.kbd>Esc</x-docs.kbd>
        </div>
        <div id="search-results" data-search-results role="listbox" class="max-h-[60vh] overflow-y-auto p-2"></div>
        <div class="flex items-center gap-4 border-t border-slate-200 px-4 py-2.5 text-xs text-slate-500 dark:border-white/10">
            <span class="flex items-center gap-1"><x-docs.kbd>↑</x-docs.kbd><x-docs.kbd>↓</x-docs.kbd> to navigate</span>
            <span class="flex items-center gap-1"><x-docs.kbd>↵</x-docs.kbd> to open</span>
        </div>
    </div>
</div>

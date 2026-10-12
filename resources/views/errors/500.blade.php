<x-layouts.site title="Something went wrong · Nitro">
    <x-docs.error code="500" title="Something went wrong on our side">
        <p>The page couldn't be shown just now. Please try again in a moment; if it keeps happening, let us know on GitHub.</p>

        <x-slot:actions>
            <a href="{{ url()->current() }}" class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-110 nitro-gradient">Try again</a>
            <a href="{{ config('docs.github') }}/issues" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:ring-white/20">Report it</a>
            <a href="/" class="px-3 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Home</a>
        </x-slot:actions>
    </x-docs.error>
</x-layouts.site>

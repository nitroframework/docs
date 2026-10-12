<x-layouts.site title="Back soon · Nitro">
    <x-docs.error code="503" title="Back in a few minutes">
        <p>The docs are being updated. Please check back shortly.</p>

        <x-slot:actions>
            <a href="{{ url()->current() }}" class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-110 nitro-gradient">Try again</a>
            <a href="{{ config('docs.github') }}" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:ring-white/20">GitHub</a>
        </x-slot:actions>
    </x-docs.error>
</x-layouts.site>

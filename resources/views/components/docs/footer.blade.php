<footer class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-10 text-sm text-slate-500 sm:flex-row lg:px-8">
        <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-4">
            <x-docs.logo class="scale-90 opacity-80" />
            <span class="text-xs">Built with Claude Design</span>
        </div>
        <nav class="flex gap-6">
            <a nitro:navigate href="/docs" class="hover:text-slate-900 dark:hover:text-white">Docs</a>
            <a href="{{ config('docs.github') }}" class="hover:text-slate-900 dark:hover:text-white">GitHub</a>
            <a href="{{ config('docs.sponsor') }}" class="hover:text-slate-900 dark:hover:text-white">Sponsor</a>
        </nav>
    </div>
</footer>

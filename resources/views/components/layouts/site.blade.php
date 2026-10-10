@props(['title' => 'Nitro: write PHP, run it in the browser'])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <x-docs.head :title="$title" />
</head>
<body class="min-h-full">
    {{-- The page's frame: two faint lines down both edges of the content, top to bottom --}}
    <div class="pointer-events-none fixed inset-0 z-30 px-px" aria-hidden="true">
        <div class="mx-auto h-full max-w-7xl border-x border-slate-900/[0.07] dark:border-white/[0.07]"></div>
    </div>

    <x-docs.header />

    {{ $slot }}

    <footer class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-10 text-sm text-slate-500 sm:flex-row lg:px-8">
            <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-4">
                <x-docs.logo class="scale-90 opacity-80" />
                <span class="text-xs">Built with Claude Design</span>
            </div>
            <nav class="flex gap-6">
                <a nitro:navigate href="/docs" class="hover:text-slate-900 dark:hover:text-white">Docs</a>
                <a href="{{ config('docs.github') }}" class="hover:text-slate-900 dark:hover:text-white">GitHub</a>
            </nav>
        </div>
    </footer>

    <x-docs.search />

    @nitroScripts
</body>
</html>

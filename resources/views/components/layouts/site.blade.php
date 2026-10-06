@props(['title' => 'Fusion: write PHP, run it in the browser'])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <x-docs.head :title="$title" />
</head>
<body class="min-h-full">
    <x-docs.header />

    {{ $slot }}

    <footer class="border-t border-zinc-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-10 text-sm text-zinc-500 sm:flex-row lg:px-8">
            <x-docs.logo class="scale-90 opacity-80" />
            <nav class="flex gap-6">
                <a fusion:navigate href="/docs" class="hover:text-zinc-900 dark:hover:text-white">Docs</a>
                <a href="{{ config('docs.github') }}" class="hover:text-zinc-900 dark:hover:text-white">GitHub</a>
            </nav>
        </div>
    </footer>

    <x-docs.search />

    @fusionScripts
</body>
</html>

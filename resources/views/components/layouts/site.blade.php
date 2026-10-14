@props(['title' => 'Nitro: PHP components for Laravel that run in the browser', 'fullFooter' => false])

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

    <x-docs.footer :full="$fullFooter" />

    <x-docs.search />

    @nitroScripts
    <x-docs.analytics />
</body>
</html>

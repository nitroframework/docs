<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <x-docs.head />
</head>
<body class="min-h-full">
    <x-docs.header />

    {{-- A demo page (App\Nitro\Pages\Demo): its whole view is Vue, React, Solid or Svelte. --}}
    <main class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <x-docs.search />

    @nitroScripts
    <x-docs.analytics />
</body>
</html>

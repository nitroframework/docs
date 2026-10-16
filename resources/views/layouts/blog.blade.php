<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <x-docs.head />
</head>
<body class="flex min-h-full flex-col">
    <x-docs.header active="blog" />

    {{-- The blog (App\Nitro\Pages\Articles): the posts, or one post. --}}
    <main class="mx-auto w-full max-w-3xl flex-1 px-4 py-12 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <x-docs.footer />

    <x-docs.search />

    @nitroScripts
    <x-docs.analytics />
</body>
</html>

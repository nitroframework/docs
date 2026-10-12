@props(['code', 'title'])

{{-- An error page's body (errors/*.blade.php): its code, what happened, and where to go from here. --}}
<main class="relative isolate overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -top-32 left-1/2 h-80 w-80 -translate-x-[70%] rounded-full bg-sky-400/20 blur-3xl dark:bg-blue-600/15"></div>
        <div class="absolute -top-16 left-1/2 h-72 w-72 translate-x-[10%] rounded-full bg-amber-300/20 blur-3xl dark:bg-amber-500/10"></div>
    </div>

    <div class="mx-auto flex min-h-[60vh] max-w-2xl flex-col items-center justify-center px-6 py-24 text-center">
        <p class="bg-gradient-to-r from-sky-500 via-blue-600 to-amber-500 bg-clip-text font-mono text-7xl font-semibold tracking-tight text-transparent sm:text-8xl">{{ $code }}</p>
        <h1 class="mt-6 text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl dark:text-white">{{ $title }}</h1>
        <div class="mt-4 max-w-lg text-[15px] leading-7 text-slate-600 dark:text-slate-400">
            {{ $slot }}
        </div>

        @isset($actions)
            <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                {{ $actions }}
            </div>
        @endisset
    </div>
</main>

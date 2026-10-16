@props(['title' => null])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="icon" href="/favicon.ico" sizes="32x32">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
@if ($title === null)
    {{-- A Nitro page: its title, description, canonical link and link preview (config/nitro.php's head). --}}
    @nitroHead
@else
    <title>{{ $title }}</title>
    <meta name="description" content="{{ config('nitro.head.description') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ config('nitro.head.description') }}">
    <meta property="og:image" content="{{ config('nitro.head.image') }}">
    <meta name="twitter:card" content="summary_large_image">
@endif
<meta property="og:site_name" content="Nitro">
<meta property="og:type" content="website">
{{-- The theme before the first paint: no flash of the wrong one. --}}
<script>
    (() => {
        let theme = 'system';
        try { theme = localStorage.getItem('theme') ?? 'system'; } catch {}
        const dark = theme === 'dark' || (theme === 'system' && matchMedia('(prefers-color-scheme: dark)').matches);
        document.documentElement.classList.toggle('dark', dark);
        document.documentElement.dataset.theme = theme;
    })();
</script>
{{-- The code blocks' token colours (App\Docs\Code::css()). --}}
<style>{!! \App\Docs\Code::css() !!}</style>
{{-- React's refresh, for npm run dev (the examples' React views); nothing in a build. --}}
@viteReactRefresh
@vite(['resources/css/app.css', 'resources/js/app.js'])

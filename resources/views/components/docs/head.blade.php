@props(['title' => null])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if ($title === null)
    {{-- A Fusion page: its title, description and canonical link (config/fusion.php's head). --}}
    @fusionHead
@else
    <title>{{ $title }}</title>
    <meta name="description" content="{{ config('fusion.head.description') }}">
@endif
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
@vite(['resources/css/app.css', 'resources/js/app.js'])

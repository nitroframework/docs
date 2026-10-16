<head>
    {{-- React's refresh, for npm run dev (nothing in a build), then your views: they register with Nitro before its components start. --}}
    @viteReactRefresh
    @vite('resources/js/app.js')
</head>
<body>
    {{ $slot }}

    @nitroScripts
</body>

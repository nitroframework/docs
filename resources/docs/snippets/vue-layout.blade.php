<head>
    {{-- Your views first: they register with Nitro before its components start. --}}
    @vite('resources/js/app.js')
</head>
<body>
    {{ $slot }}

    @nitroScripts
</body>

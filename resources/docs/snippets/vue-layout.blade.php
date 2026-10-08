<head>
    {{-- Your views first: they register with Fusion before its components start. --}}
    @vite('resources/js/app.js')
</head>
<body>
    {{ $slot }}

    @fusionScripts
</body>

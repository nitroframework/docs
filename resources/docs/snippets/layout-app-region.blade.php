<body>
    <aside class="sidebar">...</aside>

    {{-- Where this layout's pages go. --}}
    <main nitro:layout="app">
        {{ $slot }}
    </main>

    @nitroScripts
</body>

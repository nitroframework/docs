<div data-flash-updates class="w-full max-w-xl space-y-3 text-sm">
    <div class="flex flex-wrap items-center gap-3">
        <button type="button" nitro:click="increment" class="rounded-lg bg-zinc-900 px-3 py-1.5 font-semibold text-white dark:bg-white dark:text-zinc-900">+</button>
        <span>Clicked <strong>{{ $count }}</strong> times</span>
        <input nitro:model="name" class="w-32 rounded-lg bg-white px-2 py-1 ring-1 ring-zinc-300 outline-none dark:bg-zinc-900 dark:ring-white/15" aria-label="Name">
        <span>Hello, {{ $name }}</span>
        <button type="button" nitro:click="enrol" class="rounded-lg px-3 py-1.5 ring-1 ring-zinc-300 dark:ring-white/15">Enrol one</button>
    </div>
    <ul class="grid grid-cols-4 gap-1 sm:grid-cols-5">
        @foreach ($students as $i => $student)
            <li nitro:key="{{ $i }}" class="truncate rounded bg-zinc-100 px-2 py-1 dark:bg-white/5">{{ $student }}</li>
        @endforeach
    </ul>
    <p data-flash-count nitro:ignore class="text-xs text-zinc-500">Click, type or enrol: what changes flashes.</p>
</div>

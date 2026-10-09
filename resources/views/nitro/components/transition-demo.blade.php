<div class="w-full max-w-md space-y-4 text-sm">
    <div class="flex gap-1">
        @foreach (['list' => 'A list', 'panel' => 'A panel'] as $value => $label)
            <button type="button" nitro:click="$set('tab', $value)" @class(['rounded-lg px-3 py-1.5 font-medium', 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' => $tab === $value, 'ring-1 ring-zinc-300 dark:ring-white/15' => $tab !== $value])>{{ $label }}</button>
        @endforeach
    </div>

    @if ($tab === 'list')
        <section nitro:transition.out-in class="space-y-2">
            <div class="flex gap-2">
                <button type="button" nitro:click="add" class="rounded-lg px-3 py-1.5 ring-1 ring-zinc-300 dark:ring-white/15">Add</button>
                <button type="button" nitro:click="shuffle" class="rounded-lg px-3 py-1.5 ring-1 ring-zinc-300 dark:ring-white/15">Shuffle</button>
            </div>
            <ul class="space-y-1">
                @foreach ($people as $person)
                    <li nitro:key="{{ $person }}" nitro:transition.move.duration.250ms class="flex items-center justify-between rounded-lg bg-white px-3 py-2 ring-1 ring-zinc-200 dark:bg-zinc-900 dark:ring-white/10">
                        {{ $person }}
                        <button type="button" nitro:click="remove($person)" class="text-zinc-400 hover:text-red-500" aria-label="Remove {{ $person }}">&times;</button>
                    </li>
                @endforeach
            </ul>
        </section>
    @else
        <section nitro:transition.out-in class="space-y-2">
            <button type="button" nitro:click="$toggle('open')" class="rounded-lg px-3 py-1.5 ring-1 ring-zinc-300 dark:ring-white/15">{{ $open ? 'Hide' : 'Show' }} the panel</button>
            @if ($open)
                <div nitro:transition.duration.200ms.origin.top class="rounded-xl bg-violet-50 p-4 text-violet-900 ring-1 ring-violet-200 dark:bg-violet-500/10 dark:text-violet-200 dark:ring-violet-500/20">
                    The built-in fade and scale: no CSS of your own.
                </div>
            @endif
        </section>
    @endif
</div>

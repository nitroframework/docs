<div class="w-full max-w-md space-y-3 text-sm">
    <input nitro:model="draft" nitro:keydown.enter="add" nitro:keydown.escape="$set('draft', '')" placeholder="Type, then Enter to add or Escape to clear" class="w-full rounded-lg bg-white px-3 py-2 ring-1 ring-zinc-300 outline-none focus:ring-2 focus:ring-violet-500 dark:bg-zinc-900 dark:ring-white/15">

    <div class="flex items-center gap-3">
        <div class="relative" nitro:click.outside="$set('menu', false)">
            <button type="button" nitro:click="$toggle('menu')" class="rounded-lg px-3 py-1.5 font-medium ring-1 ring-zinc-300 dark:ring-white/15">
                {{ count($notes) }} {{ count($notes) === 1 ? 'note' : 'notes' }} ▾
            </button>
            @if ($menu)
                <ul class="absolute left-0 z-10 mt-1 w-56 rounded-lg bg-white p-1 shadow-lg ring-1 ring-zinc-200 dark:bg-zinc-800 dark:ring-white/10">
                    @forelse ($notes as $note)
                        <li class="truncate rounded px-2 py-1">{{ $note }}</li>
                    @empty
                        <li class="px-2 py-1 text-zinc-400">Nothing yet</li>
                    @endforelse
                </ul>
            @endif
        </div>
        <span class="text-zinc-500">Click outside to close it.</span>
    </div>

    <p nitro:poll.1s="tick" class="text-xs text-zinc-500">On this page for {{ $seconds }}s (nitro:poll, paused while the tab is hidden)</p>
</div>

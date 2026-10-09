<div class="w-full max-w-sm space-y-3">
    <form nitro:submit="add" class="flex gap-2">
        <input nitro:model="title" maxlength="100" placeholder="What needs doing?" class="flex-1 rounded-lg bg-white px-3 py-2 text-sm ring-1 ring-zinc-300 outline-none focus:ring-2 focus:ring-violet-500 dark:bg-zinc-900 dark:ring-white/15">
        <button class="rounded-lg bg-zinc-900 px-3 py-2 text-sm font-semibold text-white dark:bg-white dark:text-zinc-900">Add</button>
    </form>

    <ul class="space-y-1">
        @foreach ($todos as $i => $todo)
            <li>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" nitro:click="toggle($i)" @checked($todo['done'])>
                    <span @class(['line-through text-zinc-400' => $todo['done']])>{{ $todo['title'] }}</span>
                </label>
            </li>
        @endforeach
    </ul>

    <div class="flex items-center gap-3 text-sm text-zinc-500">
        <span>{{ $this->remaining }} left</span>
        @if ($savedAt !== '')
            <span class="ml-auto">Saved at {{ $savedAt }}. Reload the page and it stays.</span>
        @endif
        <button nitro:click="save" nitro:loading.attr="disabled" @class(['font-semibold text-zinc-900 disabled:opacity-50 dark:text-white', 'ml-auto' => $savedAt === ''])>Save</button>
    </div>
</div>

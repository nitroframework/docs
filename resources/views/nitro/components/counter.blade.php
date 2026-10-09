<div class="flex flex-wrap items-center gap-3">
    <button nitro:click="increment" class="rounded-lg bg-zinc-900 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
        Count: {{ $count }}
    </button>
    <button nitro:click="save" nitro:loading.attr="disabled" class="rounded-lg px-3.5 py-2 text-sm font-semibold text-zinc-700 ring-1 ring-zinc-300 hover:bg-zinc-50 disabled:opacity-50 dark:text-zinc-200 dark:ring-white/15 dark:hover:bg-white/5">
        Save on the server
    </button>
    <span class="text-sm text-zinc-500">{{ $savedAt === '' ? 'Not saved yet' : 'Saved at '.$savedAt.'. Reload the page and it stays.' }}</span>
    @error('count')
        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
    @enderror
</div>

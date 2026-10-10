<form nitro:submit="check" class="w-full max-w-sm space-y-2 text-sm">
    <div class="flex gap-2">
        <input nitro:model="name" placeholder="Pick a username (try admin)" class="flex-1 rounded-lg bg-white px-3 py-2 ring-1 ring-slate-300 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:ring-white/15">
        <button nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900">
            <span nitro:loading.remove>Check</span>
            <span nitro:loading>Checking…</span>
        </button>
    </div>
    @error('name')
        <p class="text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
    @if ($result !== '' && ! $errors->has('name'))
        <p class="text-slate-600 dark:text-slate-400">{{ $result }}</p>
    @endif
</form>

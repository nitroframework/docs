<div class="flex w-full max-w-lg flex-wrap items-center gap-3 text-sm">
    <button type="button" nitro:click="save" nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900">Save</button>
    @if ($this->flashed('toast'))
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">{{ $this->flashed('toast') }}</span>
    @endif
</div>

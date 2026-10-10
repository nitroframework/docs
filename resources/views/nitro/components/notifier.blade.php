<div class="flex flex-wrap gap-2 text-sm">
    <button type="button" nitro:click="$dispatch('notify', 'Copied to the clipboard')" class="rounded-lg px-3 py-2 font-medium ring-1 ring-slate-300 dark:ring-white/15">Say it from the view</button>
    <button type="button" nitro:click="save" nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900">Save, then say it from the server</button>
</div>

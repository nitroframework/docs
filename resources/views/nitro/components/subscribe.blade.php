<form nitro:submit="subscribe" novalidate class="w-full text-sm">
    <div class="flex gap-2">
        <input nitro:model="email" type="email" placeholder="you@example.com" @class(['min-w-0 flex-1 rounded-lg bg-white px-3 py-2 ring-1 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900', 'ring-red-400' => $errors->has('email'), 'ring-slate-300 dark:ring-white/15' => ! $errors->has('email')])>
        <button nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-4 py-2 font-semibold text-white transition disabled:opacity-50 dark:bg-white dark:text-slate-900">
            <span nitro:loading.remove>Subscribe</span>
            <span nitro:loading>Saving…</span>
        </button>
    </div>
    @error('email') <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    @if ($thanks !== '')
        <p class="mt-3 rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">{{ $thanks }}</p>
    @endif
</form>

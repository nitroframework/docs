<form nitro:submit="save" class="space-y-3 rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $postId === null ? 'New post' : 'Edit post' }}</h3>
        @if ($postId !== null)
            <button type="button" nitro:click="cancel" class="text-xs font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white">Cancel</button>
        @endif
    </div>

    <div>
        <input nitro:model="title" maxlength="120" placeholder="Title" aria-label="Title" class="w-full rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900">
        @error('title')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <textarea nitro:model="body" rows="6" maxlength="2000" placeholder="Write something…" aria-label="Body" class="w-full resize-y rounded-lg bg-slate-50 px-3 py-2 text-sm leading-6 ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900"></textarea>
        @error('body')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <span class="text-xs text-slate-500">{{ $this->words }} {{ $this->words === 1 ? 'word' : 'words' }}</span>
        @if ($notice !== '')
            <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">{{ $notice }}</span>
        @endif
        <button nitro:loading.attr="disabled" class="ml-auto rounded-lg bg-browser-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-browser-500 disabled:opacity-50">{{ $postId === null ? 'Publish' : 'Update' }}</button>
    </div>
</form>

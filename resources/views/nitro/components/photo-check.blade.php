<div class="w-full max-w-sm space-y-3 text-sm">
    <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 px-4 py-5 text-slate-500 hover:border-blue-400 dark:border-white/15">
        <input type="file" accept="image/*" nitro:model="photo" class="sr-only">
        <span nitro:loading.remove nitro:target="photo">Choose a photo (2 MB at most)</span>
        <span nitro:loading nitro:target="photo">Uploading…</span>
    </label>
    @error('photo') <p class="text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

    @if ($photo && str_starts_with($photo->getMimeType(), 'image/'))
        <div class="flex items-center gap-3">
            <img src="{{ $photo->temporaryUrl() }}" alt="{{ $photo->getClientOriginalName() }}" class="size-16 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-white/10">
            <div class="min-w-0 flex-1">
                <p class="truncate font-medium text-slate-900 dark:text-white">{{ $photo->getClientOriginalName() }}</p>
                <p class="text-xs text-slate-500">{{ number_format($photo->getSize() / 1024, 1) }} KB · {{ $photo->getMimeType() }}</p>
            </div>
            <button type="button" nitro:click="check" nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900">Check</button>
        </div>
    @endif

    @if ($result !== '')
        <p class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">{{ $result }}</p>
    @endif
</div>

<div class="px-4">
    <button type="button" nitro:click="toggle" class="flex w-full items-center justify-between gap-4 py-3 text-left text-sm font-medium text-slate-900 dark:text-white">
        {{ $question }}
        <span @class(['text-slate-400 transition', 'rotate-45' => $open])>+</span>
    </button>
    @if ($open)
        <p class="pb-3 text-sm text-slate-600 dark:text-slate-400">{{ $answer }}</p>
    @endif
</div>

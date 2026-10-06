<div class="px-4">
    <button type="button" fusion:click="toggle" class="flex w-full items-center justify-between gap-4 py-3 text-left text-sm font-medium text-zinc-900 dark:text-white">
        {{ $question }}
        <span @class(['text-zinc-400 transition', 'rotate-45' => $open])>+</span>
    </button>
    @if ($open)
        <p class="pb-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $answer }}</p>
    @endif
</div>

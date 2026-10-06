<div class="w-full max-w-sm space-y-2 text-sm">
    @forelse ($toasts as $toast)
        <div fusion:key="{{ $toast['id'] }}" fusion:transition.duration.200ms @class([
            'flex items-center justify-between gap-3 rounded-lg px-3 py-2 ring-1',
            'bg-emerald-50 text-emerald-800 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20' => $toast['tone'] === 'success',
            'bg-white text-zinc-700 ring-zinc-200 dark:bg-zinc-900 dark:text-zinc-300 dark:ring-white/10' => $toast['tone'] !== 'success',
        ])>
            <span>{{ $toast['message'] }}</span>
            <button type="button" fusion:click="dismiss($toast['id'])" class="opacity-60 hover:opacity-100" aria-label="Dismiss">&times;</button>
        </div>
    @empty
        <p class="text-zinc-400">No messages yet.</p>
    @endforelse
</div>

<div class="w-full max-w-sm space-y-2 text-sm">
    @forelse ($toasts as $toast)
        <div nitro:key="{{ $toast['id'] }}" nitro:transition.duration.200ms @class([
            'flex items-center justify-between gap-3 rounded-lg px-3 py-2 ring-1',
            'bg-emerald-50 text-emerald-800 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20' => $toast['tone'] === 'success',
            'bg-white text-slate-700 ring-slate-200 dark:bg-slate-900 dark:text-slate-300 dark:ring-white/10' => $toast['tone'] !== 'success',
        ])>
            <span>{{ $toast['message'] }}</span>
            <button type="button" nitro:click="dismiss($toast['id'])" class="opacity-60 hover:opacity-100" aria-label="Dismiss">&times;</button>
        </div>
    @empty
        <p class="text-slate-400">No messages yet.</p>
    @endforelse
</div>

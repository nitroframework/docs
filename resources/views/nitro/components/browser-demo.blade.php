<div class="grid w-full max-w-xl gap-6 text-sm sm:grid-cols-2">
    <div class="space-y-2">
        <label class="block font-medium" for="docs-note">A note, kept in this browser</label>
        <textarea id="docs-note" nitro:model.debounce.300ms="note" rows="3" placeholder="Type, then reload the page" class="w-full rounded-lg bg-white px-3 py-2 ring-1 ring-slate-300 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:ring-white/15"></textarea>
        <button type="button" nitro:click="copy" @disabled($note === '') class="rounded-lg px-3 py-1.5 font-medium ring-1 ring-slate-300 disabled:opacity-50 dark:ring-white/15">{{ $copied ? 'Copied ✓' : 'Copy it' }}</button>
    </div>
    <div class="space-y-2">
        <p class="font-medium">Drawn on a canvas</p>
        <canvas nitro:ref="chart" class="rounded-lg bg-white ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10"></canvas>
        <div class="grid grid-cols-4 gap-2">
            @foreach ($values as $i => $value)
                <input type="range" min="1" max="10" nitro:model.number="values.{{ $i }}" aria-label="Bar {{ $i + 1 }}">
            @endforeach
        </div>
    </div>
</div>

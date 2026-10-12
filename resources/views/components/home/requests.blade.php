{{--
    What everyday interactions cost in requests: in Nitro, where methods run in the browser, and
    where every event goes to the server first. Facts of each approach, no product named.
--}}
@php
    $rows = [
        ['Type "forms" in a search box', 0, 5, 'filtered in the browser'],
        ['Count to ten', 0, 10, 'a browser method'],
        ['Open three tabs of a panel', 0, 3, 'state in the browser'],
        ['Save the form', 1, 1, 'a #[Server] method'],
    ];
    $most = max(array_column($rows, 2));
@endphp

<div {{ $attributes->class('overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 dark:bg-slate-900/60 dark:ring-white/10') }}>
    <div class="grid grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)_minmax(0,1fr)] gap-4 border-b border-slate-200/80 px-6 py-3 text-xs font-semibold tracking-wide text-slate-500 uppercase dark:border-white/[0.07]">
        <span>You</span>
        <span class="text-browser-600 dark:text-browser-400">Nitro</span>
        <span>Every event to the server</span>
    </div>
    @foreach ($rows as [$what, $nitro, $server, $why])
        <div class="grid grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)_minmax(0,1fr)] items-center gap-4 border-b border-slate-200/60 px-6 py-4 last:border-b-0 dark:border-white/[0.05]">
            <div>
                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $what }}</p>
                <p class="mt-0.5 text-xs text-slate-500">{{ $why }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="w-6 text-right font-mono text-sm font-semibold tabular-nums {{ $nitro === 0 ? 'text-browser-600 dark:text-browser-400' : 'text-server-600 dark:text-server-400' }}">{{ $nitro }}</span>
                <span class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-100 dark:bg-white/[0.05]"><span class="block h-full rounded-full nitro-gradient" style="width: {{ $nitro / $most * 100 }}%"></span></span>
            </div>
            <div class="flex items-center gap-3">
                <span class="w-6 text-right font-mono text-sm font-semibold text-slate-600 tabular-nums dark:text-slate-300">{{ $server }}</span>
                <span class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-100 dark:bg-white/[0.05]"><span class="block h-full rounded-full bg-slate-400 dark:bg-slate-500" style="width: {{ $server / $most * 100 }}%"></span></span>
            </div>
        </div>
    @endforeach
</div>

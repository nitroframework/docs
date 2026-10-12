@props(['url'])

{{-- A homepage demo in a small browser window: its address bar, then the component running. --}}
<div class="overflow-hidden rounded-xl bg-white ring-1 ring-slate-200 dark:bg-slate-950/60 dark:ring-white/10">
    <div class="flex items-center gap-2 border-b border-slate-200/80 bg-slate-100/70 px-4 py-2.5 dark:border-white/[0.07] dark:bg-white/[0.03]">
        <span class="flex gap-1.5"><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i></span>
        <span class="ml-2 flex-1 truncate rounded-md bg-white px-3 py-1 font-mono text-xs text-slate-500 ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-white/10">{{ $url }}</span>
    </div>
    <div class="p-5">{{ $slot }}</div>
</div>

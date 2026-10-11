{{-- Nitro in one picture, on a loop (the mech-* keyframes in app.css): the PHP you write, compiled to JavaScript;
     clicks run in the browser with no request, and only the #[Server] method calls the server. --}}
<div {{ $attributes->class('mech relative min-w-0 select-none') }} role="img"
     aria-label="A PHP component is compiled to JavaScript. Clicking plus updates the count in the browser with no request; Save calls the server once.">

    {{-- 1. The PHP you write, with a light travelling round its edge (.card-edge) --}}
    <div class="relative">
        <div class="card-edge" aria-hidden="true"></div>
        <div class="relative overflow-hidden rounded-[1.3rem] bg-white shadow-xl shadow-slate-900/5 dark:bg-slate-900 dark:shadow-black/20">
            <div class="flex items-center justify-between border-b border-slate-200/80 px-4 py-2.5 dark:border-white/[0.07]">
                <span class="font-mono text-xs text-slate-500">Counter.php</span>
                <span class="text-[11px] font-medium text-slate-400">You write PHP</span>
            </div>
            <pre class="overflow-hidden px-4 py-3 font-mono text-[10px] leading-5 sm:text-[12.5px] sm:leading-6 text-slate-600 dark:text-slate-300"><span class="text-sky-600 dark:text-sky-400">class</span> Counter <span class="text-sky-600 dark:text-sky-400">extends</span> Component
{
    <span class="text-sky-600 dark:text-sky-400">public int</span> $count = 0;

<span class="mech-line mech-line--browser">    <span class="text-sky-600 dark:text-sky-400">public function</span> increment() { $this->count++; }<span class="mech-tag mech-tag--browser">browser</span></span>

    <span class="text-amber-600 dark:text-amber-400">#[Server]</span>
<span class="mech-line mech-line--server">    <span class="text-sky-600 dark:text-sky-400">public function</span> save() { Score::create(); }<span class="mech-tag mech-tag--server">server</span></span>
}</pre>
        </div>
    </div>

    {{-- 2. Compiled once --}}
    <div class="relative mx-auto flex h-16 w-full items-center justify-center">
        <div class="mech-flow absolute inset-y-0 left-1/2 w-px -translate-x-1/2 bg-slate-200 dark:bg-white/10">
            <span></span><span></span><span></span>
        </div>
        <span class="relative rounded-full bg-white px-3 py-1 font-mono text-[11px] font-medium text-slate-600 ring-1 ring-slate-200 dark:bg-slate-900 dark:text-slate-300 dark:ring-white/10">compiled to JavaScript</span>
    </div>

    {{-- 3. The browser and the server --}}
    <div class="grid grid-cols-[minmax(0,1fr)_1.25rem_minmax(0,0.7fr)] items-center sm:grid-cols-[minmax(0,1fr)_3.5rem_minmax(0,0.8fr)]">
        <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
            <div class="flex items-center gap-1.5 border-b border-slate-200/80 px-3 py-2 dark:border-white/[0.07]">
                <span class="size-2 rounded-full bg-slate-300 dark:bg-white/15"></span><span class="size-2 rounded-full bg-slate-300 dark:bg-white/15"></span><span class="size-2 rounded-full bg-slate-300 dark:bg-white/15"></span>
                <span class="ml-auto text-[11px] font-medium text-browser-600 dark:text-browser-400">Browser</span>
            </div>
            <div class="flex items-center justify-between gap-2 px-3 py-4 sm:gap-3 sm:px-4">
                <span class="mech-count font-mono text-2xl sm:text-3xl font-semibold text-slate-900 tabular-nums dark:text-white"><span><span>0</span><span>1</span><span>2</span><span>3</span><span>0</span></span></span>
                <div class="flex gap-1.5 sm:gap-2">
                    <span class="mech-btn mech-btn--plus rounded-lg bg-browser-500 px-2.5 py-1.5 sm:px-3 text-sm font-semibold text-white">+</span>
                    <span class="mech-btn mech-btn--save rounded-lg bg-slate-900 px-2.5 py-1.5 sm:px-3 text-sm font-semibold text-white dark:bg-white/10">Save</span>
                </div>
            </div>
            <div class="mech-requests border-t border-slate-200/80 px-4 py-2 text-[11px] dark:border-white/[0.07]">
                <span class="mech-requests--none text-browser-600 dark:text-browser-400">0 requests<span class="hidden sm:inline">: it runs right here</span></span>
                <span class="mech-requests--one text-amber-600 dark:text-amber-400">1 request<span class="hidden sm:inline">, for save()</span></span>
            </div>
        </div>

        <div class="mech-wire relative h-px bg-slate-200 dark:bg-white/10"><span></span></div>

        <div class="mech-server overflow-hidden rounded-2xl bg-white px-3 py-4 sm:px-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
            <p class="text-[11px] font-medium text-amber-600 dark:text-amber-400">Server</p>
            <p class="mt-1 font-mono text-[12px] text-slate-600 dark:text-slate-300">save()</p>
            <p class="mech-saved mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">Saved ✓</p>
        </div>
    </div>
</div>

@props(['title'])

<li class="relative pl-8 [counter-increment:step]">
    <span class="absolute -left-3.5 top-0 flex size-7 items-center justify-center rounded-full bg-white text-xs font-semibold text-slate-900 ring-1 ring-slate-200 before:content-[counter(step)] dark:bg-slate-950 dark:text-white dark:ring-white/15"></span>
    <h4 class="pt-0.5 text-[15px] font-semibold text-slate-900 dark:text-white">{{ $title }}</h4>
    <div class="prose-docs mt-2 [&>.code-frame]:mb-0 [&>p]:my-2">{{ $slot }}</div>
</li>

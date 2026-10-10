<div>
    <div class="flex items-center gap-2 border-b border-slate-200/80 bg-slate-100/70 px-4 py-2.5 dark:border-white/[0.07] dark:bg-white/[0.03]">
        <span class="flex gap-1.5"><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i><i class="size-2.5 rounded-full bg-slate-300 dark:bg-white/15"></i></span>
        <span class="ml-2 flex-1 truncate rounded-md bg-white px-3 py-1 font-mono text-xs text-slate-500 ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-white/10">blog.test/posts{{ $search === '' ? '' : '?q='.urlencode($search) }}</span>
    </div>

    <div class="p-5">
        <input nitro:model="search" type="search" placeholder="Search posts..." class="w-full rounded-lg bg-white px-3 py-2 text-sm ring-1 ring-slate-300 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:ring-white/15">

        <ul class="mt-2 min-h-60 divide-y divide-slate-200/70 dark:divide-white/[0.06]">
            @forelse ($this->found as $post)
                <li class="flex items-baseline justify-between gap-4 py-2.5 text-sm">
                    <span class="font-medium text-slate-900 dark:text-white">{{ $post['title'] }}</span>
                    <span class="shrink-0 text-xs text-slate-500">{{ $post['author'] }} · {{ $post['minutes'] }} min</span>
                </li>
            @empty
                <li class="py-8 text-center text-sm text-slate-500">No post matches “{{ $search }}”.</li>
            @endforelse
        </ul>
    </div>
</div>

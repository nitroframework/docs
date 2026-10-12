<div class="space-y-3">
    <div class="flex items-center gap-2">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Posts</h3>
        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600 dark:bg-white/10 dark:text-slate-300">{{ count($posts) }}</span>
    </div>

    <label class="relative block">
        <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="4.5"/><path d="m10.5 10.5 3 3" stroke-linecap="round"/></svg>
        <input nitro:model="search" type="search" maxlength="100" placeholder="Search posts" aria-label="Search posts" class="w-full rounded-lg bg-white py-2 pr-3 pl-9 text-sm ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-browser-500 dark:bg-slate-900 dark:ring-white/10">
    </label>

    @if (count($this->results) === 0)
        <p class="rounded-xl border border-dashed border-slate-300 px-4 py-6 text-center text-sm text-slate-500 dark:border-white/15">
            {{ $search === '' ? 'No posts yet. Write the first one.' : 'No posts match your search.' }}
        </p>
    @endif

    <ul class="space-y-3">
        @foreach ($this->results as $post)
            <li nitro:key="{{ $post['id'] }}" class="rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h4 class="truncate font-semibold text-slate-900 dark:text-white">{{ $post['title'] }}</h4>
                        <p class="mt-0.5 text-xs text-slate-500">{{ $post['date'] }}</p>
                    </div>
                    @if ($confirming === $post['id'])
                        <div class="flex shrink-0 items-center gap-1">
                            <button type="button" nitro:click="remove($post['id'])" nitro:loading.attr="disabled" class="rounded-md bg-red-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-red-500 disabled:opacity-50">Delete</button>
                            <button type="button" nitro:click="confirmDelete(null)" class="rounded-md px-2 py-1 text-xs font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-white/10">Keep</button>
                        </div>
                    @else
                        <div class="flex shrink-0 items-center gap-1">
                            <button type="button" nitro:click="edit($post)" class="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/10">Edit</button>
                            <button type="button" nitro:click="confirmDelete($post['id'])" class="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 dark:text-slate-300 dark:hover:bg-red-500/10">Delete</button>
                        </div>
                    @endif
                </div>
                <p @class(['mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400', 'line-clamp-2' => $open !== $post['id']])>{{ $post['body'] }}</p>
                @if (mb_strlen($post['body']) > 140 || str_contains($post['body'], "\n"))
                    <button type="button" nitro:click="read($post['id'])" class="mt-1 text-xs font-medium text-browser-600 hover:text-browser-500 dark:text-browser-400">{{ $open === $post['id'] ? 'Show less' : 'Read more' }}</button>
                @endif
            </li>
        @endforeach
    </ul>
</div>

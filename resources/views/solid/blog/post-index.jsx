import { For, Show } from 'solid-js';

export default function PostIndex(props) {
    return (
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Posts</h3>
                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600 dark:bg-white/10 dark:text-slate-300">{props.posts.length}</span>
            </div>

            <label class="relative block">
                <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="4.5" /><path d="m10.5 10.5 3 3" stroke-linecap="round" /></svg>
                <input value={props.search} onInput={(e) => props.set('search', e.currentTarget.value)} type="search" maxLength={100} placeholder="Search posts" aria-label="Search posts" class="w-full rounded-lg bg-white py-2 pr-3 pl-9 text-sm ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-browser-500 dark:bg-slate-900 dark:ring-white/10" />
            </label>

            <Show when={props.results.length === 0}>
                <p class="rounded-xl border border-dashed border-slate-300 px-4 py-6 text-center text-sm text-slate-500 dark:border-white/15">
                    {props.search === '' ? 'No posts yet. Write the first one.' : 'No posts match your search.'}
                </p>
            </Show>

            <ul class="space-y-3">
                <For each={props.results}>
                    {(post) => (
                        <li class="rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h4 class="truncate font-semibold text-slate-900 dark:text-white">{post.title}</h4>
                                    <p class="mt-0.5 text-xs text-slate-500">{post.date}</p>
                                </div>
                                <Show
                                    when={props.confirming === post.id}
                                    fallback={
                                        <div class="flex shrink-0 items-center gap-1">
                                            <button type="button" class="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/10" onClick={() => props.edit(post)}>Edit</button>
                                            <button type="button" class="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 dark:text-slate-300 dark:hover:bg-red-500/10" onClick={() => props.confirmDelete(post.id)}>Delete</button>
                                        </div>
                                    }
                                >
                                    <div class="flex shrink-0 items-center gap-1">
                                        <button type="button" disabled={props.remove.processing} class="rounded-md bg-red-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-red-500 disabled:opacity-50" onClick={() => props.remove(post.id)}>Delete</button>
                                        <button type="button" class="rounded-md px-2 py-1 text-xs font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-white/10" onClick={() => props.confirmDelete(null)}>Keep</button>
                                    </div>
                                </Show>
                            </div>
                            <p class="mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400" classList={{ 'line-clamp-2': props.open !== post.id }}>{post.body}</p>
                            <Show when={post.body.length > 140 || post.body.includes('\n')}>
                                <button type="button" class="mt-1 text-xs font-medium text-browser-600 hover:text-browser-500 dark:text-browser-400" onClick={() => props.read(post.id)}>{props.open === post.id ? 'Show less' : 'Read more'}</button>
                            </Show>
                        </li>
                    )}
                </For>
            </ul>
        </div>
    );
}

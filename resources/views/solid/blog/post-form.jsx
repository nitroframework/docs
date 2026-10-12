import { Show } from 'solid-js';

export default function PostForm(props) {
    function submit(event) {
        event.preventDefault();
        props.save();
    }

    return (
        <form class="space-y-3 rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" onSubmit={submit}>
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{props.postId === null ? 'New post' : 'Edit post'}</h3>
                <Show when={props.postId !== null}>
                    <button type="button" class="text-xs font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white" onClick={() => props.cancel()}>Cancel</button>
                </Show>
            </div>

            <div>
                <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} maxLength={120} placeholder="Title" aria-label="Title" class="w-full rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900" />
                <Show when={props.errors.title}>{(messages) => <p class="mt-1 text-xs text-red-600 dark:text-red-400">{messages()[0]}</p>}</Show>
            </div>

            <div>
                <textarea value={props.body} onInput={(e) => props.set('body', e.currentTarget.value)} rows={6} maxLength={2000} placeholder="Write something…" aria-label="Body" class="w-full resize-y rounded-lg bg-slate-50 px-3 py-2 text-sm leading-6 ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900" />
                <Show when={props.errors.body}>{(messages) => <p class="mt-1 text-xs text-red-600 dark:text-red-400">{messages()[0]}</p>}</Show>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500">{props.words} {props.words === 1 ? 'word' : 'words'}</span>
                <Show when={props.notice}>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">{props.notice}</span>
                </Show>
                <button disabled={props.save.processing} class="ml-auto rounded-lg bg-browser-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-browser-500 disabled:opacity-50">{props.postId === null ? 'Publish' : 'Update'}</button>
            </div>
        </form>
    );
}

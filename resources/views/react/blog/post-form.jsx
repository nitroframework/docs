export default function PostForm({ postId, title, body, notice, words, errors, set, save, cancel }) {
    function submit(event) {
        event.preventDefault();
        save();
    }

    return (
        <form className="space-y-3 rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" onSubmit={submit}>
            <div className="flex items-center justify-between">
                <h3 className="text-sm font-semibold text-slate-900 dark:text-white">{postId === null ? 'New post' : 'Edit post'}</h3>
                {postId !== null && (
                    <button type="button" className="text-xs font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white" onClick={cancel}>Cancel</button>
                )}
            </div>

            <div>
                <input value={title} onChange={(e) => set('title', e.target.value)} maxLength={120} placeholder="Title" aria-label="Title" className="w-full rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900" />
                {errors.title && <p className="mt-1 text-xs text-red-600 dark:text-red-400">{errors.title[0]}</p>}
            </div>

            <div>
                <textarea value={body} onChange={(e) => set('body', e.target.value)} rows={6} maxLength={2000} placeholder="Write something…" aria-label="Body" className="w-full resize-y rounded-lg bg-slate-50 px-3 py-2 text-sm leading-6 ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900" />
                {errors.body && <p className="mt-1 text-xs text-red-600 dark:text-red-400">{errors.body[0]}</p>}
            </div>

            <div className="flex items-center gap-3">
                <span className="text-xs text-slate-500">{words} {words === 1 ? 'word' : 'words'}</span>
                {notice && <span className="text-xs font-medium text-emerald-600 dark:text-emerald-400">{notice}</span>}
                <button disabled={save.processing} className="ml-auto rounded-lg bg-browser-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-browser-500 disabled:opacity-50">{postId === null ? 'Publish' : 'Update'}</button>
            </div>
        </form>
    );
}

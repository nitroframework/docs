export default function PostIndex({ posts, results, search, open, confirming, set, read, edit, confirmDelete, remove }) {
    return (
        <div className="space-y-3">
            <div className="flex items-center gap-2">
                <h3 className="text-sm font-semibold text-slate-900 dark:text-white">Posts</h3>
                <span className="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600 dark:bg-white/10 dark:text-slate-300">{posts.length}</span>
            </div>

            <label className="relative block">
                <svg className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" strokeWidth="1.5"><circle cx="7" cy="7" r="4.5" /><path d="m10.5 10.5 3 3" strokeLinecap="round" /></svg>
                <input value={search} onChange={(e) => set('search', e.target.value)} type="search" maxLength={100} placeholder="Search posts" aria-label="Search posts" className="w-full rounded-lg bg-white py-2 pr-3 pl-9 text-sm ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-browser-500 dark:bg-slate-900 dark:ring-white/10" />
            </label>

            {results.length === 0 && (
                <p className="rounded-xl border border-dashed border-slate-300 px-4 py-6 text-center text-sm text-slate-500 dark:border-white/15">
                    {search === '' ? 'No posts yet. Write the first one.' : 'No posts match your search.'}
                </p>
            )}

            <ul className="space-y-3">
                {results.map((post) => (
                    <li key={post.id} className="rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                        <div className="flex items-start justify-between gap-3">
                            <div className="min-w-0">
                                <h4 className="truncate font-semibold text-slate-900 dark:text-white">{post.title}</h4>
                                <p className="mt-0.5 text-xs text-slate-500">{post.date}</p>
                            </div>
                            {confirming === post.id ? (
                                <div className="flex shrink-0 items-center gap-1">
                                    <button type="button" disabled={remove.processing} className="rounded-md bg-red-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-red-500 disabled:opacity-50" onClick={() => remove(post.id)}>Delete</button>
                                    <button type="button" className="rounded-md px-2 py-1 text-xs font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-white/10" onClick={() => confirmDelete(null)}>Keep</button>
                                </div>
                            ) : (
                                <div className="flex shrink-0 items-center gap-1">
                                    <button type="button" className="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/10" onClick={() => edit(post)}>Edit</button>
                                    <button type="button" className="rounded-md px-2 py-1 text-xs font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 dark:text-slate-300 dark:hover:bg-red-500/10" onClick={() => confirmDelete(post.id)}>Delete</button>
                                </div>
                            )}
                        </div>
                        <p className={`mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400 ${open === post.id ? '' : 'line-clamp-2'}`}>{post.body}</p>
                        {(post.body.length > 140 || post.body.includes('\n')) && (
                            <button type="button" className="mt-1 text-xs font-medium text-browser-600 hover:text-browser-500 dark:text-browser-400" onClick={() => read(post.id)}>{open === post.id ? 'Show less' : 'Read more'}</button>
                        )}
                    </li>
                ))}
            </ul>
        </div>
    );
}

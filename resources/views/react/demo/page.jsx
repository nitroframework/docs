export default function Page({ results, search, title, body, errors, set, publish, link }) {
    return (
        <div className="space-y-8">
            <header className="rounded-2xl bg-sky-50 p-6 ring-1 ring-sky-200 dark:bg-sky-500/10 dark:ring-sky-500/20">
                <p className="text-sm font-semibold text-sky-700 dark:text-sky-300">This is a React page</p>
                <h1 className="mt-1 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">The whole page is one .jsx file</h1>
                <p className="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">
                    Its class, <code>App\Nitro\Pages\Demo\ReactPage</code>, is routed with <code>Route::nitro()</code> and
                    loads the posts in <code>mount()</code>. Its view is <code>resources/views/react/demo/page.jsx</code>:
                    there is no Blade view. Search runs in the browser; publishing is a <code>#[Server]</code> method.
                </p>
                <nav className="mt-4 flex flex-wrap gap-2 text-sm">
                    <a {...link('/demo/vue', 'prefetch')} className="demo-switch">Vue page</a>
                    <a {...link('/demo/solid', 'prefetch')} className="demo-switch">Solid page</a>
                    <a {...link('/demo/svelte', 'prefetch')} className="demo-switch">Svelte page</a>
                    <a {...link('/docs/javascript-pages')} className="demo-switch">Back to the docs</a>
                </nav>
            </header>

            <form className="space-y-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" onSubmit={(e) => { e.preventDefault(); publish(); }}>
                <h2 className="text-sm font-semibold text-slate-900 dark:text-white">Write a post</h2>
                <input value={title} onChange={(e) => set('title', e.target.value)} placeholder="Title" aria-label="Title" className="demo-input" />
                {errors.title && <p className="text-xs text-red-600">{errors.title[0]}</p>}
                <textarea value={body} onChange={(e) => set('body', e.target.value)} rows={3} placeholder="What happened?" aria-label="Body" className="demo-input" />
                {errors.body && <p className="text-xs text-red-600">{errors.body[0]}</p>}
                <button disabled={publish.processing} className="demo-button">{publish.processing ? 'Publishing…' : 'Publish'}</button>
            </form>

            <section className="space-y-3">
                <input value={search} onChange={(e) => set('search', e.target.value)} type="search" placeholder="Search posts" aria-label="Search posts" className="demo-input" />
                {results.length === 0 && <p className="text-center text-sm text-slate-500">No posts match your search.</p>}
                {results.map((post) => (
                    <article key={post.id} className="rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                        <h3 className="font-semibold text-slate-900 dark:text-white">{post.title}</h3>
                        <p className="mt-0.5 text-xs text-slate-500">{post.date}</p>
                        <p className="mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400">{post.body}</p>
                    </article>
                ))}
            </section>
        </div>
    );
}

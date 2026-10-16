import { For, Show } from 'solid-js';

export default function Page(props) {
    return (
        <div class="space-y-8">
            <header class="rounded-2xl bg-blue-50 p-6 ring-1 ring-blue-200 dark:bg-blue-500/10 dark:ring-blue-500/20">
                <p class="text-sm font-semibold text-blue-700 dark:text-blue-300">This is a Solid page</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">The whole page is one .jsx file</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">
                    Its class, <code>App\Nitro\Pages\Demo\SolidPage</code>, is routed with <code>Route::nitro()</code> and
                    loads the posts in <code>mount()</code>. Its view is <code>resources/views/solid/demo/page.jsx</code>:
                    there is no Blade view. Search runs in the browser; publishing is a <code>#[Server]</code> method.
                </p>
                <nav class="mt-4 flex flex-wrap gap-2 text-sm">
                    <a {...props.link('/demo/vue', 'prefetch')} class="demo-switch">Vue page</a>
                    <a {...props.link('/demo/react', 'prefetch')} class="demo-switch">React page</a>
                    <a {...props.link('/demo/svelte', 'prefetch')} class="demo-switch">Svelte page</a>
                    <a {...props.link('/docs/solid#pages')} class="demo-switch">Back to the docs</a>
                </nav>
            </header>

            <form class="space-y-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" onSubmit={(e) => { e.preventDefault(); props.publish(); }}>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Write a post</h2>
                <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} placeholder="Title" aria-label="Title" class="demo-input" />
                <Show when={props.errors.title}><p class="text-xs text-red-600">{props.errors.title[0]}</p></Show>
                <textarea value={props.body} onInput={(e) => props.set('body', e.currentTarget.value)} rows={3} placeholder="What happened?" aria-label="Body" class="demo-input" />
                <Show when={props.errors.body}><p class="text-xs text-red-600">{props.errors.body[0]}</p></Show>
                <button disabled={props.publish.processing} class="demo-button">{props.publish.processing ? 'Publishing…' : 'Publish'}</button>
            </form>

            <section class="space-y-3">
                <input value={props.search} onInput={(e) => props.set('search', e.currentTarget.value)} type="search" placeholder="Search posts" aria-label="Search posts" class="demo-input" />
                <Show when={props.results.length === 0}><p class="text-center text-sm text-slate-500">No posts match your search.</p></Show>
                <For each={props.results}>
                    {(post) => (
                        <article class="rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                            <h3 class="font-semibold text-slate-900 dark:text-white">{post.title}</h3>
                            <p class="mt-0.5 text-xs text-slate-500">{post.date}</p>
                            <p class="mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400">{post.body}</p>
                        </article>
                    )}
                </For>
            </section>
        </div>
    );
}

<script>
    let { results, search = $bindable(), title = $bindable(), body = $bindable(), errors, publish, link } = $props();
</script>

<div class="space-y-8">
    <header class="rounded-2xl bg-orange-50 p-6 ring-1 ring-orange-200 dark:bg-orange-500/10 dark:ring-orange-500/20">
        <p class="text-sm font-semibold text-orange-700 dark:text-orange-300">This is a Svelte page</p>
        <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">The whole page is one .svelte file</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">
            Its class, <code>App\Nitro\Pages\Demo\SveltePage</code>, is routed with <code>Route::nitro()</code> and loads
            the posts in <code>mount()</code>. Its view is <code>resources/views/svelte/demo/page.svelte</code>: there is
            no Blade view. Search runs in the browser; publishing is a <code>#[Server]</code> method.
        </p>
        <nav class="mt-4 flex flex-wrap gap-2 text-sm">
            <a {...link('/demo/vue', 'prefetch')} class="demo-switch">Vue page</a>
            <a {...link('/demo/react', 'prefetch')} class="demo-switch">React page</a>
            <a {...link('/demo/solid', 'prefetch')} class="demo-switch">Solid page</a>
            <a {...link('/docs/javascript-pages')} class="demo-switch">Back to the docs</a>
        </nav>
    </header>

    <form class="space-y-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" onsubmit={(e) => { e.preventDefault(); publish(); }}>
        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Write a post</h2>
        <input bind:value={title} placeholder="Title" aria-label="Title" class="demo-input">
        {#if errors.title}<p class="text-xs text-red-600">{errors.title[0]}</p>{/if}
        <textarea bind:value={body} rows="3" placeholder="What happened?" aria-label="Body" class="demo-input"></textarea>
        {#if errors.body}<p class="text-xs text-red-600">{errors.body[0]}</p>{/if}
        <button disabled={publish.processing} class="demo-button">{publish.processing ? 'Publishing…' : 'Publish'}</button>
    </form>

    <section class="space-y-3">
        <input bind:value={search} type="search" placeholder="Search posts" aria-label="Search posts" class="demo-input">
        {#if results.length === 0}<p class="text-center text-sm text-slate-500">No posts match your search.</p>{/if}
        {#each results as post (post.id)}
            <article class="rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                <h3 class="font-semibold text-slate-900 dark:text-white">{post.title}</h3>
                <p class="mt-0.5 text-xs text-slate-500">{post.date}</p>
                <p class="mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400">{post.body}</p>
            </article>
        {/each}
    </section>
</div>

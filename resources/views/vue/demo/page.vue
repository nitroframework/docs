<template>
    <div class="space-y-8">
        <header class="rounded-2xl bg-emerald-50 p-6 ring-1 ring-emerald-200 dark:bg-emerald-500/10 dark:ring-emerald-500/20">
            <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">This is a Vue page</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">The whole page is one .vue file</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">
                Its class, <code>App\Nitro\Pages\Demo\VuePage</code>, is routed with <code>Route::nitro()</code> and loads
                the posts in <code>mount()</code>. Its view is <code>resources/views/vue/demo/page.vue</code>: there is no
                Blade view. Search runs in the browser; publishing is a <code>#[Server]</code> method.
            </p>
            <nav class="mt-4 flex flex-wrap gap-2 text-sm">
                <a v-bind="link('/demo/react', 'prefetch')" class="demo-switch">React page</a>
                <a v-bind="link('/demo/solid', 'prefetch')" class="demo-switch">Solid page</a>
                <a v-bind="link('/demo/svelte', 'prefetch')" class="demo-switch">Svelte page</a>
                <a v-bind="link('/docs/vue#pages')" class="demo-switch">Back to the docs</a>
            </nav>
        </header>

        <form class="space-y-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" @submit.prevent="publish()">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Write a post</h2>
            <input v-model="title" placeholder="Title" aria-label="Title" class="demo-input">
            <p v-if="errors.title" class="text-xs text-red-600">{{ errors.title[0] }}</p>
            <textarea v-model="body" rows="3" placeholder="What happened?" aria-label="Body" class="demo-input"></textarea>
            <p v-if="errors.body" class="text-xs text-red-600">{{ errors.body[0] }}</p>
            <button :disabled="publish.processing" class="demo-button">{{ publish.processing ? 'Publishing…' : 'Publish' }}</button>
        </form>

        <section class="space-y-3">
            <input v-model="search" type="search" placeholder="Search posts" aria-label="Search posts" class="demo-input">
            <p v-if="results.length === 0" class="text-center text-sm text-slate-500">No posts match your search.</p>
            <article v-for="post in results" :key="post.id" class="rounded-2xl bg-white p-5 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
                <h3 class="font-semibold text-slate-900 dark:text-white">{{ post.title }}</h3>
                <p class="mt-0.5 text-xs text-slate-500">{{ post.date }}</p>
                <p class="mt-2 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400">{{ post.body }}</p>
            </article>
        </section>
    </div>
</template>

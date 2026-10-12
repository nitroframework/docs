<x-docs.page
    lead="One small blog, built five times: with Blade, Vue, React, Solid and Svelte views. The PHP is the same each time; only the views change. Each one runs live on its page."
>
    <p>
        Each blog has a form to write and edit posts, and a list to search, read and delete them. They are two
        components that talk through events, as the parts of a real app would. Every page shows its files in full,
        exactly as they run.
    </p>

    @php
        $examples = [
            ['examples-blade', 'Blog in Blade', 'Nitro\'s own views: Blade, compiled to run in the browser too.'],
            ['examples-vue', 'Blog in Vue', '.vue templates, with v-model on the component\'s properties.'],
            ['examples-react', 'Blog in React', 'The component as props, set() for inputs.'],
            ['examples-solid', 'Blog in Solid', 'Fine-grained props: only what changed updates.'],
            ['examples-svelte', 'Blog in Svelte', 'The component from $props(), bind:value for inputs.'],
            ['examples-together', 'All together', 'All five on one page, talking through events, and live with Reverb.'],
        ];
    @endphp

    <div class="not-prose my-8 grid gap-3 sm:grid-cols-2">
        @foreach ($examples as [$slug, $title, $text])
            <a nitro:navigate href="/docs/{{ $slug }}" class="group rounded-xl p-4 ring-1 ring-slate-200 transition hover:ring-slate-300 dark:ring-white/10 dark:hover:ring-white/20">
                <span class="font-semibold text-slate-900 group-hover:text-browser-600 dark:text-white dark:group-hover:text-browser-400">{{ $title }}</span>
                <span class="mt-1 block text-sm text-slate-600 dark:text-slate-400">{{ $text }}</span>
            </a>
        @endforeach
    </div>

    <h2 id="the-posts">The posts are yours</h2>
    <p>
        The examples keep posts in your session, so you can write anything: no one else sees it, and it's gone when
        the session ends. Every page starts with the same few posts. A post you write on one page shows up on the
        others, since they share your session.
    </p>
    <p>
        Everything you type is shown as text, never as HTML, in each framework: Blade's <code>@{{ }}</code>,
        Vue's <code>@{{ }}</code>, React's, Solid's and Svelte's <code>{ }</code> all escape it. The rules on
        the form are checked in the browser as you type, and again on the server, which is the check that counts.
    </p>
</x-docs.page>

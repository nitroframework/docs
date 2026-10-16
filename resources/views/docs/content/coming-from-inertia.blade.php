<x-docs.page
    lead="If you know Inertia, you know most of Nitro already: Laravel routes, pages rendered by the server first, visits that fetch only data, shared and deferred props. The difference is where a page lives. In Inertia it is a controller and a Vue or React page; in Nitro it is one PHP class, and its view can be Blade or Vue, React, Solid or Svelte."
>
    <h2 id="one-class">A page is its own controller</h2>
    <p>
        An Inertia page is two things: a controller action that gathers props and calls
        <code>Inertia::render()</code>, and a JavaScript page that receives them. Every change goes back through
        another route and controller: a form posts, the controller validates and redirects back, and the page
        receives its props again.
    </p>
    <p>
        A Nitro page is one class. Its public properties are the props, <code>mount()</code> is the controller
        action, and its methods are the actions on the page. There is no <code>Nitro::render()</code>: you route the
        class, and Nitro renders it.
    </p>

    <h2 id="side-by-side">The same page, both ways</h2>
    <p>A post with a comment form. In Inertia, two routes, two controllers and a page:</p>

    <x-docs.code src="inertia-controller.php" file="Inertia: routes and controllers" />
    <x-docs.code src="inertia-page.vue" lang="vue" file="Inertia: resources/js/Pages/Posts/Show.vue" />

    <p>In Nitro, one route and one class, with its view:</p>

    <x-docs.code src="inertia-nitro-route.php" file="routes/web.php" />
    <x-docs.code src="inertia-nitro-page.php" file="app/Nitro/Pages/Posts/Show.php" runs="both" highlight="14,20,23,27" />
    <x-docs.code src="inertia-nitro-page.vue" lang="vue" file="resources/views/vue/posts/show.vue" />

    <ul>
        <li><strong>No props to declare.</strong> The view reads the page's properties by their PHP names: <code>post</code>, <code>comment</code>, <code>errors</code>. <code>v-model</code> writes them.</li>
        <li><strong>No form helper.</strong> The form's fields are properties, and <code>addComment()</code> is the submit. <code>addComment.processing</code> is what <code>form.processing</code> was, and <code>errors</code> holds the messages.</li>
        <li><strong>No second route.</strong> <code>#[Server]</code> methods are called on the page itself, with its state signed by the server. <code>#[Locked]</code> keeps the browser from changing <code>post</code>.</li>
        <li><strong>No redirect back.</strong> The page stays where it is: the call changes <code>comment</code>, and the view shows it.</li>
    </ul>

    <p>
        The view could be Blade instead, with the same class: drop <code>vue:</code> from <code>#[View]</code>.
        Pages with Blade views run their browser methods without any framework at all, and a Blade page can place
        components with Vue, React, Solid or Svelte views side by side (see
        <a nitro:navigate href="/docs/javascript-views">JavaScript views</a>).
    </p>

    <x-docs.callout type="tip" title="See it running">
        <p>The same kind of page, a blog searched in the browser and written on the server, built four times: with a <a href="/demo/vue">Vue</a>, <a href="/demo/react">React</a>, <a href="/demo/solid">Solid</a> and <a href="/demo/svelte">Svelte</a> view. Their links visit each other without a reload.</p>
    </x-docs.callout>

    <h2 id="mapping">Inertia's features in Nitro</h2>
    <p>The server side:</p>

    @php
        $server = [
            ['`Inertia::render(\'Posts/Show\', [...])`', 'A page class: its public properties, set in `mount()`', 'Pages'],
            ['`Inertia::share()`', '`Nitro::share()`, read with `$this->shared()`', 'Page data'],
            ['`Inertia::once()`, `shareOnce()`', '`Nitro::once()`, `Nitro::shareOnce()`', 'Page data'],
            ['`Inertia::flash()`', '`Nitro::flash()`, read with `$this->flashed()`', 'Page data'],
            ['`Inertia::defer()`', '`$this->defer(\'stats\', fn () => ...)` in `mount()`', 'Page data'],
            ['`Inertia::merge()`, `deepMerge()`', '`$this->merge()`, `$this->deepMerge()`', 'Page data'],
            ['`Inertia::scroll()`', '`$this->scroll()` with a paginator, `$loadMore()` in the view', 'Page data'],
            ['Partial reloads (`only`)', '`$this->reload(\'orders\')` or `$reload(\'orders\')`; `$this->wants()` skips the work a reload doesn\'t need', 'Page data'],
            ['Asset versioning', 'The build\'s version: a visit from another build loads the page in full', 'Building for production'],
            ['`<Head>`, `title`', '`#[Title]`, `$this->head()`', 'The page\'s head'],
            ['`redirect()` from a controller', '`$this->redirect($url, navigate: true)` in a method', 'Server methods'],
            ['Validation errors in props', '`#[Validate]`, `$this->validate()`, `$errors` in the view', 'Forms and validation'],
            ['Testing helpers', '`assertNitro()` on a page\'s response, `callNitro()` for a `#[Server]` method', 'Testing'],
        ];
    @endphp
    <x-docs.table :columns="['Inertia', 'Nitro', 'Read']" :rows="$server" />

    <p>The browser side:</p>

    @php
        $client = [
            ['`<Link href>`', '`<a nitro:navigate href>`; `visit(url)` in a Vue view', 'Navigation'],
            ['`router.visit()`', '`$visit()` in Blade, `visit()` in a JavaScript view', 'Navigation'],
            ['`router.reload({ only })`', '`$reload(\'orders\')`', 'Page data'],
            ['Link prefetching', '`nitro:prefetch`, on hover or `.visible`', 'Navigation'],
            ['The progress bar', 'Nitro\'s progress bar, or your own', 'Navigation'],
            ['View transitions', '`view_transitions`, or `.transition` on a link', 'Navigation'],
            ['`useForm()`', 'The page\'s properties, `#[Validate]`, a `#[Server]` method and its `processing`', 'Forms and validation'],
            ['`form.isDirty`', '`nitro:dirty` in Blade, `unsaved` in a JavaScript view', 'Forms and validation'],
            ['`useRemember()`', '`#[Remember]` on a property', 'Properties'],
            ['`usePoll()`', '`nitro:poll.30s="refresh"`', 'Directives'],
            ['`<WhenVisible>`', '`nitro:visible="loadMore"`', 'Directives'],
            ['`<InfiniteScroll>`', '`$this->scroll()` and `nitro:visible="$loadMore(\'posts\')"`', 'Page data'],
        ];
    @endphp
    <x-docs.table :columns="['Inertia', 'Nitro', 'Read']" :rows="$client" />

    <p>
        Read more in <a nitro:navigate href="/docs/pages">Pages</a>, <a nitro:navigate href="/docs/page-data">Page data</a>,
        <a nitro:navigate href="/docs/navigation">Navigation</a>, <a nitro:navigate href="/docs/head">The page's head</a>,
        <a nitro:navigate href="/docs/forms">Forms and validation</a>, <a nitro:navigate href="/docs/server-methods">Server methods</a>,
        <a nitro:navigate href="/docs/properties">Properties</a>, <a nitro:navigate href="/docs/directives#polling">Directives</a>
        and <a nitro:navigate href="/docs/testing">Testing</a>.
    </p>

    <h2 id="what-nitro-adds">What Nitro adds</h2>
    <ul>
        <li><strong>Methods that run in the browser, written in PHP.</strong> A method without <code>#[Server]</code> is compiled to JavaScript and runs on a click with no request. In Inertia, that logic is written again in the page's JavaScript. See <a nitro:navigate href="/docs/methods">Methods</a>.</li>
        <li><strong>Server calls without routes.</strong> A <code>#[Server]</code> method is called from the view by name, with its arguments and its return value, and the page's state travels with it, signed. See <a nitro:navigate href="/docs/server-methods">Server methods</a>.</li>
        <li><strong>Validation as fields are left.</strong> <code>#[Validate(onBlur: true)]</code> checks a field on the server when the visitor leaves it, before the form is sent. See <a nitro:navigate href="/docs/forms#validate-on-blur">Forms and validation</a>.</li>
        <li><strong>Components, not only pages.</strong> A search box, a cart or a table is a component with its own state and methods, placed on any page. See <a nitro:navigate href="/docs/components">Components</a>.</li>
        <li><strong>Stores.</strong> State shared between components, per tab or per request, with methods compiled like a component's. See <a nitro:navigate href="/docs/sharing-state">Sharing state</a>.</li>
        <li><strong>Blade views that run in the browser.</strong> No framework needed for a page that doesn't want one; islands and server-made HTML for the parts that should stay on the server. See <a nitro:navigate href="/docs/islands">Islands</a> and <a nitro:navigate href="/docs/html">Server-made HTML</a>.</li>
        <li><strong>Mistakes fail the build.</strong> A browser method that queries the database, or a reserved name, is an error naming the file and line. See <a nitro:navigate href="/docs/how-it-works">How Nitro works</a>.</li>
    </ul>

    <h2 id="differences">What is different</h2>
    <p>Some of Inertia's features have no counterpart in Nitro:</p>

    @php
        $missing = [
            ['`Inertia::optional()`', 'A prop left out of the first load and sent only when asked for. Nitro\'s `wants()` skips work on a reload of other properties, not on the first load; `defer()` loads the property right after the page shows'],
            ['`Inertia::always()`', 'A prop sent with every partial reload. A Nitro reload takes the properties you name'],
            ['`encryptHistory()`, `clearHistory()`', 'Encrypting the history entries\' data. Don\'t put secrets in a `#[Remember]` property'],
            ['`preserveFragment`', 'Keeping the `#fragment` across a redirect'],
            ['Turning server rendering off per request', 'Server rendering is on or off for the app, in `nitro.ssr.enabled`'],
        ];
    @endphp
    <x-docs.table :columns="['Inertia', 'In Nitro']" :rows="$missing" />

    <p>And some things work differently:</p>
    <ul>
        <li><strong>Posting forms to routes.</strong> You can, but you don't need to: a <code>#[Server]</code> method replaces the route, the controller and the redirect back.</li>
        <li><strong>One Vue app per page.</strong> Inertia mounts one app and swaps pages inside it. In Nitro each component with a Vue view is its own app; share state between them with stores, events or one Pinia (see <a nitro:navigate href="/docs/vue">Vue</a>).</li>
        <li><strong>A JavaScript view can't place Nitro components.</strong> Compose components from Blade: a Blade page or layout can hold several, whatever their views.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/pages" title="Pages" icon="book">Route a page, choose its layout and load its data in mount().</x-docs.card>
        <x-docs.card href="/docs/vue" title="Vue" icon="code">Write a component's or a page's view as a Vue single-file component.</x-docs.card>
        <x-docs.card href="/docs/page-data" title="Page data" icon="server" runs="server">Defer, reload and merge properties, and share data with every page.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

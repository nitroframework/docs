<x-docs.page
    lead="A component's or a page's view can be a Vue, React, Solid or Svelte component instead of Blade. The PHP class doesn't change: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. Only the view does, and it works with the component by the same names, in the framework's own way."
>
    <p>
        Blade is Nitro's own view engine: Nitro compiles it, and renders it on the server and in the browser. A
        JavaScript view is a component of the framework you choose, built by your app's Vite like any other. Nitro
        gives it the component (its state, its methods, its server calls, its validation messages) and keeps them in
        step. You write the view the way that framework is written, and the PHP the way Nitro is.
    </p>

    <p>Every view works everywhere a view can be:</p>

    @php
        $views = [
            ['Blade', '✓', '✓', '✓', '✓', '✓'],
            ['Vue', '✓', '✓', '✓', '✓', '✓'],
            ['React', '✓', '✓', '✓', '✓', '✓'],
            ['Solid', '✓', '✓', '✓', '✓', '✓'],
            ['Svelte', '✓', '✓', '✓', '✓', '✓'],
        ];
    @endphp
    <x-docs.table :columns="['View', 'A component', 'A whole page', 'Visits to and from any other', 'Events with any other', 'Server rendering']" :rows="$views" />

    <ul>
        <li><strong>A component</strong> is placed from Blade, beside components with any other view (<a href="#side-by-side">Side by side on a page</a>).</li>
        <li><strong>A whole page</strong> is routed, with its view inside a Blade layout (<a nitro:navigate href="/docs/javascript-pages">Pages</a>).</li>
        <li><strong>Visits</strong> go from a page with one view to a page with another without a reload (<a nitro:navigate href="/docs/javascript-pages#visits">Visits between frameworks</a>).</li>
        <li><strong>Events</strong> sent by one component reach <code>#[On]</code> methods whatever their views are (<a href="#talking">Talking to each other</a>).</li>
        <li><strong>Server rendering</strong> puts JavaScript views in the page's first HTML, as Blade's are (<a nitro:navigate href="/docs/server-rendering">Server rendering</a>).</li>
    </ul>

    <x-docs.cards>
        <x-docs.card href="/docs/vue" title="Vue" icon="browser">Templates and <code>v-model</code> on the component's properties; <code>useNitro()</code> refs in <code>&lt;script setup&gt;</code>.</x-docs.card>
        <x-docs.card href="/docs/react" title="React" icon="browser">The component as props, re-rendered as it changes; <code>useNitro()</code> for the tree below.</x-docs.card>
        <x-docs.card href="/docs/solid" title="Solid" icon="browser">Fine-grained props: only what reads a changed value updates.</x-docs.card>
        <x-docs.card href="/docs/svelte" title="Svelte" icon="browser">The component from <code>$props()</code>, reactive with runes.</x-docs.card>
    </x-docs.cards>

    <h2 id="when">When to use one</h2>
    <p>Blade is the default, and the right choice for most views. Reach for a JavaScript view when:</p>
    <ul>
        <li><strong>A library you want is written for a framework</strong>: a rich text editor, a chart, a date picker, a drag-and-drop board, a map.</li>
        <li><strong>Your team already writes one</strong>, and has components to reuse.</li>
        <li><strong>A view is mostly interaction</strong>: many small pieces of state that live only in the browser, animation, canvas work.</li>
    </ul>
    <p>
        You don't have to choose for the whole app. The choice is per component, and components with different views
        sit side by side on a page, talking through events and stores as any Nitro components do.
    </p>

    <h2 id="same-component">One component, any view</h2>
    <p>
        The class names its view with <code>#[View]</code>: <code>vue:</code>, <code>react:</code>,
        <code>solid:</code> or <code>svelte:</code>. Everything else is the class you would write for Blade:
    </p>

    <x-docs.code src="js-views-component.php" file="app/Nitro/Components/PostEditor.php" runs="both" />

    <p>
        The view is named by its file under the framework's folder, with dots or slashes for its folders, as a Blade view's
        name: <code>vue: 'posts.editor'</code> and <code>vue: 'posts/editor'</code> are both
        <code>resources/views/vue/posts/editor.vue</code>. A file with dots in its own name, such as
        <code>editor.client.vue</code>, is found by its name as written first. If a name matches two files, the build says
        so, naming both.
    </p>

    <p>Whichever view it has, the component behaves the same:</p>
    <ul>
        <li><strong><code>addTag()</code> runs in the browser</strong>, compiled from the PHP. No request.</li>
        <li><strong><code>save()</code> runs on the server</strong>, with the browser's changes sent along and the state signed, so <code>#[Locked]</code> properties can't be forged. Its rules are checked there, and its value comes back to the view.</li>
        <li><strong><code>words</code></strong> is worked out again when <code>body</code> changes, wherever it changes.</li>
        <li><strong>Validation messages, unsaved changes, uploads, and a call's progress</strong> reach the view the same way.</li>
    </ul>

    <x-docs.callout type="note" title="Tested as one">
        <p>Nitro's browser tests run one component against its Blade, Vue, React, Solid and Svelte views, with the same steps, and expect the same results from each: typing, methods, server calls, validation, uploads, links, server rendering and hydration.</p>
    </x-docs.callout>

    <h2 id="what-the-view-gets">What every view gets</h2>
    <p>
        Each framework's page shows these in its own idiom (refs in Vue, props in React and Solid, <code>$props()</code>
        in Svelte), but the names and what they do are the same in all four:
    </p>

    @php
        $names = [
            ['Properties', '`title`, `tags`', 'By their PHP names. Arrays, models as objects with their attributes, uploads as `Upload` objects, enums as their cases'],
            ['#[Computed] values', '`words`', 'Worked out again when what they read changes'],
            ['Browser methods', '`addTag(tag)`', 'Run in the browser, compiled from the PHP'],
            ['#[Server] methods', '`save()`', 'A promise of the method\'s value; `null` when its rules refused the data'],
            ['A call\'s status', '`save.processing` `save.slow` `save.failed` `save.error`', '`slow` once the call has taken 200 ms; `failed` when the request itself failed'],
            ['`errors`', '`errors.title?.[0]`', 'The validation messages, by field, as `$errors` has them'],
            ['`unsaved`', '`unsaved.length`', 'The properties changed in the browser that the server hasn\'t seen yet'],
            ['`uploads`', '`uploads.cover?.progress`', 'Each upload while it runs: `uploading`, `progress`, `error`'],
            ['`set(path, value)`', '`set(\'form.email\', value)`', 'Writes a property, or a key under one'],
            ['`upload(path, files)`', '`upload(\'cover\', files)`', 'Files into an `Upload` or `#[Uploads]` property'],
            ['`validate(path)`', '`validate(\'email\')`', 'Checks a property against its `#[Validate]` rules on the server, for your own blur: `errors` follows, nothing else changes'],
            ['`dispatch(event, ...)`', '`dispatch(\'saved\', id)`', 'As `$dispatch` in Blade'],
            ['`link(href, ...modifiers)`', '`link(\'/posts\', \'prefetch\')`', 'A `nitro:navigate` link\'s attributes, to spread on an `<a>`'],
            ['`visit(url)`', '`visit(\'/posts\')`', 'A visit without a reload, as `$visit` in Blade'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Example', 'What it is']" :rows="$names" />

    <h2 id="setup">Several frameworks in one app</h2>
    <p>
        Each framework's page shows its own setup. To use several, add each one's Vite plugin and register each one's
        views. React and Solid both compile <code>.jsx</code>, so tell each which folders are its own:
    </p>

    <x-docs.code src="js-views-setup.js" lang="js" />

    <p>
        <code>only('react')</code> is the <code>.js</code>, <code>.jsx</code>, <code>.ts</code> and <code>.tsx</code> files
        under <code>resources/views/react</code> and <code>resources/js/react</code>, where Nitro looks for React's views;
        <code>only('solid')</code> the same under <code>solid</code>. Keep each framework's own components (a view's
        children too) under its folders. If your views are somewhere else, name the folders, from your app's root:
        <code>only('react', 'resources/frontend/react')</code>. With only one of the two, or with Vue and Svelte, you need
        none of this: each plugin knows its own files.
    </p>
    <p>
        With React, the layout also needs Laravel's <code>@@viteReactRefresh</code> before <code>@@vite</code>, for
        <code>npm run dev</code> (see <a nitro:navigate href="/docs/react#setup">React</a>).
    </p>

    <p>
        Nitro's Vite plugin gives you <code>nitro/vue</code>, <code>/react</code>, <code>/solid</code> and
        <code>/svelte</code> (and their <code>/server</code> parts for server rendering), keeps a single copy of each
        framework in the bundle, and leaves a <code>.vue</code> or <code>.svelte</code> file's <code>&lt;php&gt;</code>
        block to Nitro. Only the frameworks you register are bundled.
    </p>

    <h2 id="lazy">Loading a framework where it's used</h2>
    <p>
        <code>nitroVue()</code> and the others put the framework in your app's main script, so every page loads
        it. That's right when most pages have a view of that framework. When only a few do (a React chart on the
        reports page, a Vue editor in the admin), register it with <code>lazy()</code> instead: the framework then
        loads with the first view that needs it, and pages without one never download it.
    </p>

    <x-docs.code src="js-views-lazy.js" lang="js" />

    <p>
        Nothing else changes: the components and their views are the same, and a page that places one renders it as
        before. The framework loads once and is kept for the next page. On a visit, Nitro loads it with the page's
        views before it shows the page, so nothing fills in late. If loading fails (a network blip), the next view
        tries again.
    </p>
    <x-docs.callout>
        These docs register all four frameworks with <code>lazy()</code>: only the <a nitro:navigate href="/docs/examples">examples</a>
        load them, and every other page stays light.
    </x-docs.callout>

    <h2 id="side-by-side">Side by side on a page</h2>
    <p>
        Components are placed from Blade, whatever their view. A page can hold a Vue desk, a React card and a Blade
        list together:
    </p>

    <x-docs.code src="js-views-side-by-side.blade.php" lang="blade" />

    <p>
        Each JavaScript view is its own app (its own Vue app, React root, Solid root or Svelte app) mounted in its
        component's element. A JavaScript view can't place <code>&lt;nitro:...&gt;</code> components inside itself;
        compose them from Blade, as above.
    </p>

    <h2 id="talking">Components that talk to each other</h2>
    <p>
        Components with different views talk the way any Nitro components do: through their PHP. One dispatches an
        event, the others listen with <code>#[On]</code>. None of them needs to know what the others are written in,
        and their listeners run in the browser, so the views follow at once.
    </p>

    <x-docs.tabs>
        <x-docs.tab label="The Vue desk sends">
            <x-docs.code src="js-views-events-send.php" bare />
        </x-docs.tab>
        <x-docs.tab label="The React card listens">
            <x-docs.code src="js-views-events-listen.php" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <ul>
        <li><strong>From a browser method</strong>, the event is sent in the browser: no request.</li>
        <li><strong>From a <code>#[Server]</code> method</strong>, it is sent with the answer, once the server has done its work.</li>
        <li><strong>From the view itself</strong>, <code>dispatch('event', ...)</code> sends one, as <code>$dispatch</code> does in Blade.</li>
        <li><strong>To one component</strong>: <code>$this-&gt;dispatch(...)-&gt;to('react.post-preview')</code>.</li>
        <li><strong>The view's own code</strong> can listen on <code>window</code> for an event sent without <code>-&gt;to()</code>.</li>
    </ul>
    <p>For state that several components share and keep, rather than news of something that happened, use a <a href="/docs/sharing-state">store</a>.</p>

    <h2 id="co-located">The PHP in the view's file</h2>
    <p>
        A small component can live in one file: its class in a <code>&lt;php&gt;</code> block at the top of a
        <code>.vue</code> or <code>.svelte</code> file, or in a <code>/* &lt;php&gt; ... &lt;/php&gt; */</code> comment
        at the top of a <code>.jsx</code> or <code>.tsx</code> file. Nitro makes it a class named after the view, and
        an error in it names the line in the view. Each framework's page has an example.
    </p>
    <p>
        The two ways mix freely in one app: a class with its view beside it for components that grow, both in one file
        for small ones.
    </p>

    <h2 id="folders">Keeping them by framework</h2>
    <p>
        A component's name follows its folder, so putting classes in a folder per framework puts the framework in the
        tag where the component is placed:
    </p>

    <x-docs.code src="js-views-folders.blade.php" lang="blade" />

    <p>
        It is a convention, not a rule: feature folders (<code>Posts/</code>, <code>Comments/</code>) work the same.
        The view's file is named by <code>#[View]</code>, so moving a class doesn't move its view.
    </p>

    <h2 id="visits">On a visit</h2>
    <p>
        When <code>nitro:navigate</code> visits a page, the browser loads the code of the JavaScript views the page
        places before it shows the page, alongside its data. The page appears with its views already rendered, not
        filling in one by one after it. A view's code loads once, and is kept for the next page that shows it. A
        framework registered with <a href="#lazy">lazy()</a> loads with its first view the same way.
    </p>

    <h2 id="server-rendering">Server rendering</h2>
    <p>
        Without it, the page's HTML has each JavaScript view's element and the component's state, and the browser
        renders the view. With <a href="/docs/server-rendering">server rendering</a>, a small Node service renders the
        views into the page's first HTML, for search engines and a first paint that shows them, and the browser
        hydrates them. It is optional, falls back to the browser whenever it can't render, and needs no change to the
        views.
    </p>

    <h2 id="upgrades">Framework upgrades</h2>
    <p>
        All four adapters share one core, which holds everything about a Nitro component that isn't a framework's own
        reactivity. Each adapter only binds that core to its framework, through the framework's public API alone (Vue's
        refs, React's <code>useSyncExternalStore</code>, Solid's stores, Svelte's <code>$state</code>). A new release of
        Vue, React, Solid or Svelte needs nothing from Nitro beyond the tests that run each view against the others.
    </p>

    <h2 id="own-engine">Another framework</h2>
    <p>
        <code>nitro.views</code> lists the engines: where each one's views are, their extensions, and the adapter that
        knows the framework's files. Add an entry for another framework, with an adapter class of your own (extending
        <code>Nitro\View\ScriptEngine</code>) or none, and register its browser side with
        <code>Nitro.engine()</code>. See <a href="/docs/javascript#engines">a view engine of your own</a>.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-pages" title="Pages" icon="book">A whole page in Vue, React, Solid or Svelte.</x-docs.card>
        <x-docs.card href="/docs/vue" title="Vue" icon="browser">Everything a Vue view can do.</x-docs.card>
        <x-docs.card href="/docs/server-rendering" title="Server rendering" icon="server">JavaScript views in the page's first HTML.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

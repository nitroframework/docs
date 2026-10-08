<x-docs.page
    lead="A component's view can be a Vue, React, Solid or Svelte component instead of Blade. The PHP class doesn't change: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. Only the view does, and it works with the component by the same names, in the framework's own way."
>
    <p>
        Blade is Fusion's own view engine: Fusion compiles it, and renders it on the server and in the browser. A
        JavaScript view is a component of the framework you choose, built by your app's Vite like any other. Fusion
        gives it the component (its state, its methods, its server calls, its validation messages) and keeps them in
        step. You write the view the way that framework is written, and the PHP the way Fusion is.
    </p>

    <x-docs.cards>
        <x-docs.card href="/docs/vue" title="Vue" icon="browser">Templates and <code>v-model</code> on the component's properties; <code>useFusion()</code> refs in <code>&lt;script setup&gt;</code>.</x-docs.card>
        <x-docs.card href="/docs/react" title="React" icon="browser">The component as props, re-rendered as it changes; <code>useFusion()</code> for the tree below.</x-docs.card>
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
        sit side by side on a page, talking through events and stores as any Fusion components do.
    </p>

    <h2 id="same-component">One component, any view</h2>
    <p>
        The class names its view with <code>#[View]</code>: <code>vue:</code>, <code>react:</code>,
        <code>solid:</code> or <code>svelte:</code>. Everything else is the class you would write for Blade:
    </p>

    <x-docs.code src="js-views-component.php" file="app/Fusion/Components/PostEditor.php" runs="both" />

    <p>Whichever view it has, the component behaves the same:</p>
    <ul>
        <li><strong><code>addTag()</code> runs in the browser</strong>, compiled from the PHP. No request.</li>
        <li><strong><code>save()</code> runs on the server</strong>, with the browser's changes sent along and the state signed, so <code>#[Locked]</code> properties can't be forged. Its rules are checked there, and its value comes back to the view.</li>
        <li><strong><code>words</code></strong> is worked out again when <code>body</code> changes, wherever it changes.</li>
        <li><strong>Validation messages, unsaved changes, uploads, and a call's progress</strong> reach the view the same way.</li>
    </ul>

    <x-docs.callout type="note" title="Tested as one">
        <p>Fusion's browser tests run one component against its Blade, Vue, React, Solid and Svelte views, with the same steps, and expect the same results from each: typing, methods, server calls, validation, uploads, links, server rendering and hydration.</p>
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
            ['`dispatch(event, ...)`', '`dispatch(\'saved\', id)`', 'As `$dispatch` in Blade'],
            ['`link(href, ...modifiers)`', '`link(\'/posts\', \'prefetch\')`', 'A `fusion:navigate` link\'s attributes, to spread on an `<a>`'],
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
        Fusion's Vite plugin gives you <code>nitro-fusion/vue</code>, <code>/react</code>, <code>/solid</code> and
        <code>/svelte</code> (and their <code>/server</code> parts for server rendering), keeps a single copy of each
        framework in the bundle, and leaves a <code>.vue</code> or <code>.svelte</code> file's <code>&lt;php&gt;</code>
        block to Fusion. Only the frameworks you register are bundled.
    </p>

    <h2 id="side-by-side">Side by side on a page</h2>
    <p>
        Components are placed from Blade, whatever their view. A page can hold a Vue desk, a React card and a Blade
        list together:
    </p>

    <x-docs.code src="js-views-side-by-side.blade.php" lang="blade" />

    <p>
        Each JavaScript view is its own app (its own Vue app, React root, Solid root or Svelte app) mounted in its
        component's element. A JavaScript view can't place <code>&lt;fusion:...&gt;</code> components inside itself;
        compose them from Blade, as above.
    </p>

    <h2 id="talking">Components that talk to each other</h2>
    <p>
        Components with different views talk the way any Fusion components do: through their PHP. One dispatches an
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
        <li><strong>To one component</strong>: <code>$this-&gt;dispatch(...)-&gt;to('react.student-card')</code>.</li>
        <li><strong>The view's own code</strong> can listen on <code>window</code> for an event sent without <code>-&gt;to()</code>.</li>
    </ul>
    <p>For state that several components share and keep, rather than news of something that happened, use a <a href="/docs/sharing-state">store</a>.</p>

    <h2 id="co-located">The PHP in the view's file</h2>
    <p>
        A small component can live in one file: its class in a <code>&lt;php&gt;</code> block at the top of a
        <code>.vue</code> or <code>.svelte</code> file, or in a <code>/* &lt;php&gt; ... &lt;/php&gt; */</code> comment
        at the top of a <code>.jsx</code> or <code>.tsx</code> file. Fusion makes it a class named after the view, and
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
        It is a convention, not a rule: feature folders (<code>Billing/</code>, <code>Students/</code>) work the same.
        The view's file is named by <code>#[View]</code>, so moving a class doesn't move its view.
    </p>

    <h2 id="visits">On a visit</h2>
    <p>
        When <code>fusion:navigate</code> visits a page, the browser loads the code of the JavaScript views the page
        places before it shows the page, alongside its data. The page appears with its views already rendered, not
        filling in one by one after it. A view's code loads once, and is kept for the next page that shows it.
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
        All four adapters share one core, which holds everything about a Fusion component that isn't a framework's own
        reactivity. Each adapter only binds that core to its framework, through the framework's public API alone (Vue's
        refs, React's <code>useSyncExternalStore</code>, Solid's stores, Svelte's <code>$state</code>). A new release of
        Vue, React, Solid or Svelte needs nothing from Fusion beyond the tests that run each view against the others.
    </p>

    <h2 id="own-engine">Another framework</h2>
    <p>
        <code>fusion.views</code> lists the engines: where each one's views are, their extensions, and the adapter that
        knows the framework's files. Add an entry for another framework, with an adapter class of your own (extending
        <code>Nitro\Fusion\View\ScriptEngine</code>) or none, and register its browser side with
        <code>Fusion.engine()</code>. See <a href="/docs/javascript#engines">a view engine of your own</a>.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/vue" title="Vue" icon="browser">Everything a Vue view can do.</x-docs.card>
        <x-docs.card href="/docs/server-rendering" title="Server rendering" icon="server">JavaScript views in the page's first HTML.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="Put a page's Vue, React, Solid and Svelte views in its first HTML. Search engines and link previews see them, the first paint shows them, and the browser hydrates them: it takes over the elements that are there rather than rendering them again."
>
    <p>
        Blade views are always rendered on the server: they are Fusion's own. A JavaScript view is different. Without
        server rendering, the page's HTML has the view's element and the component's state, and the browser renders
        the view once its code has loaded. With it, your app's <strong>render service</strong>, a small Node process,
        renders the view, Laravel puts the HTML in the page, and the browser picks up from there.
    </p>

    <x-docs.callout type="note" title="Optional, and safe to turn off">
        <p>Nothing in a view changes for server rendering. Turn it on when a page's JavaScript views matter for search or for the first paint; leave it off for views behind a login, where neither does.</p>
    </x-docs.callout>

    <h2 id="how">How it works</h2>
    <x-docs.steps>
        <x-docs.step title="Laravel renders the page">
            <p>Blade views render as always. For each JavaScript view, Laravel sends the render service the view's name and the component's state: the same state the browser gets.</p>
        </x-docs.step>
        <x-docs.step title="The service renders the view">
            <p>It renders the view through the same adapter code the browser uses, from the same state, and answers with its HTML. Laravel puts it in the component's element.</p>
        </x-docs.step>
        <x-docs.step title="The browser hydrates it">
            <p>When the component starts, its adapter hydrates the HTML instead of rendering into an empty element: Vue's <code>createSSRApp</code>, React's <code>hydrateRoot</code>, Solid's and Svelte's <code>hydrate</code>. Event handlers attach, and the view is live.</p>
        </x-docs.step>
    </x-docs.steps>

    <p>
        Because both sides render from the same state through the same code, the service's HTML is what the
        browser's first render would be, and hydration finds what it expects.
    </p>

    <h2 id="setup">Setting it up</h2>

    <h3 id="entry">The render service's entry</h3>
    <p>
        Name a renderer for each framework your views use. Each takes your views as <code>import.meta.glob()</code>
        gives them, with <code>{ eager: true }</code>: the service loads them all when it starts.
    </p>

    <x-docs.code src="ssr-entry.js" lang="js" />

    <p>
        A renderer takes the same options as the browser's registration: Vue's <code>setup(app)</code>, React's
        <code>wrap(view)</code>. Create what they install per render (a new Pinia, a new query client): the service
        renders for every visitor, so nothing should be shared between them.
    </p>

    <h3 id="vite">Vite</h3>
    <p>Give Laravel's Vite plugin the entry as its <code>ssr</code> input:</p>

    <x-docs.code src="ssr-vite.js" lang="js" />

    <p>
        Solid compiles a component differently for the browser and the server: turn on <code>ssr: true</code> in
        <code>vite-plugin-solid</code>, so both builds are hydratable. Vue, React and Svelte need nothing more.
    </p>

    <h3 id="build">Build and start it</h3>

    <x-docs.code src="ssr-build.sh" lang="sh" />

    <p>
        <code>vite build --ssr</code> bundles the entry to <code>bootstrap/ssr/ssr.js</code>.
        <code>php artisan fusion:ssr</code> runs that bundle with Node, on the port in <code>fusion.ssr.url</code>.
        Then turn server rendering on:
    </p>

    <x-docs.code code="FUSION_SSR=true" lang="sh" file=".env" />

    <h2 id="configuration">Configuration</h2>

    <x-docs.code src="ssr-config.php" />

    @php
        $options = [
            ['`enabled`', '`false`', 'Whether pages ask the render service. Off, the browser renders every JavaScript view'],
            ['`url`', '`http://127.0.0.1:13714`', 'Where the service listens. `fusion:ssr` takes its port from here'],
            ['`timeout`', '`2`', 'Seconds a view may take before the page goes out without it'],
            ['`bundle`', '`bootstrap/ssr/ssr.js`', 'What `fusion:ssr` runs. `php artisan fusion:ssr --bundle=...` runs another'],
        ];
    @endphp
    <x-docs.table :columns="['Option', 'Default', 'What it does']" :rows="$options" />

    <p>
        The service listens on <code>127.0.0.1</code> only: Laravel is its one client. <code>GET /health</code> answers
        with the engines it serves, for a health check.
    </p>

    <h2 id="failures">When it can't render</h2>
    <p>Server rendering never holds a page up, and never breaks one. Each case falls back to what the page does without it:</p>

    @php
        $failures = [
            ['The service isn\'t running', 'The connection is refused at once. The request\'s views go to the browser, and Laravel logs a warning'],
            ['It is slow', 'After `timeout` seconds the view goes to the browser. The rest of the request doesn\'t ask again'],
            ['A view throws while it renders', 'That view goes to the browser, and the error is logged. The other views are served'],
            ['The entry names no renderer for an engine', 'Those views are the browser\'s. That is not an error: serve only the frameworks you want rendered'],
            ['The state can\'t be sent as JSON', 'The view goes to the browser, with a warning naming it'],
        ];
    @endphp
    <x-docs.table :columns="['When', 'What happens']" :rows="$failures" />

    <h2 id="writing-views">Writing views that render on the server</h2>
    <ul>
        <li><strong>A view only reads while it renders.</strong> Calling a method, <code>set()</code>, <code>upload()</code> or <code>dispatch()</code> during the render throws on the server, and the view is left to the browser. Do them in event handlers, as you would anyway.</li>
        <li><strong>Browser-only code</strong> (<code>window</code>, <code>document</code>, <code>localStorage</code>, measuring an element) goes where each framework runs code only in the browser: Vue's <code>onMounted</code>, React's <code>useEffect</code>, Solid's <code>onMount</code>, Svelte's <code>$effect</code> or <code>onMount</code>.</li>
        <li><strong>The first render must match.</strong> A value that differs between the server and the browser (the current time, a random number) makes hydration find something else. Work it out after mounting, or put it on the component, where both sides read the same value.</li>
        <li><strong>Validation messages are in the HTML.</strong> A page rendered after a failed form shows its <code>errors</code> in the first paint, as Blade does.</li>
    </ul>

    <h2 id="production">In production</h2>
    <p>
        Build both bundles in your deploy, then keep <code>fusion:ssr</code> running as a service, and restart it after
        each deploy so it serves the new views. With Supervisor:
    </p>

    <x-docs.code src="ssr-supervisor.ini" lang="ini" />

    <p>
        Run <code>supervisorctl restart fusion-ssr</code> as a deploy step. Pages keep working while it restarts: their
        views are rendered by the browser for those few moments.
    </p>

    <h2 id="own-engine">A view engine of your own</h2>
    <p>
        The service serves any engine named in <code>serve()</code>. A renderer is an object with
        <code>render(view, handle)</code> that returns the view's HTML; <code>handle</code> is what the browser's first
        render reads (<code>handle.get(name)</code>, <code>handle.errors()</code>, the component's names), made from the
        state Laravel sent:
    </p>

    <x-docs.code src="ssr-own-engine.js" lang="js" />

    <p>
        On the browser side, the engine's <code>mount()</code> is told <code>{ hydrate: true }</code> when the element
        holds the server's HTML. See <a href="/docs/javascript#engines">a view engine of your own</a>.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="book">Vue, React, Solid and Svelte views, and how they fit into Fusion.</x-docs.card>
        <x-docs.card href="/docs/production" title="Building for production" icon="bolt">Fusion's build, caches and what to run on each deploy.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

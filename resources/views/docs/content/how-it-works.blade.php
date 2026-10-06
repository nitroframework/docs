<x-docs.page
    lead="Each Fusion component runs in two places. This page explains what the compiler makes of your code, what the server sends on the first load, and what happens when you click and when you call the server."
>
    <h2 id="the-compiler">The compiler</h2>
    <p>
        Fusion reads each component's class and view and compiles them to JavaScript. It compiles the methods the
        browser can reach, and turns the view into a tree of elements with its dynamic parts. During development,
        this happens on the first request after you change a component. For production, you run
        <code>php artisan fusion:build</code> to do it ahead of time.
    </p>
    <ul>
        <li><strong>PHP's rules still hold.</strong> Arrays are values, <code>==</code> compares the way PHP compares, strings are bytes, and functions behave as PHP's do. All of this is checked against PHP itself.</li>
        <li><strong>The browser only gets what it needs.</strong> Fusion never compiles a method the browser can't reach, such as a helper that you only call from <code>mount()</code>.</li>
        <li><strong>Mistakes fail the build.</strong> A browser method that queries the database, or a view the browser can't render the same way, causes an error that names the file and line. You find out during development, not in production.</li>
    </ul>

    <h2 id="the-first-render">The first render</h2>
    <p>
        The server renders the page with Blade, just as Laravel renders any view. The HTML arrives complete, so it
        appears quickly and search engines and link previews can read it. Along with it comes each component's
        <strong>state</strong>, signed by the server.
    </p>
    <p>
        The browser then takes over the page. It doesn't render the page again. Instead, it attaches to the
        elements the server sent, so nothing moves or flickers. From then on, the component is live.
    </p>

    <h2 id="a-click">What happens on a click</h2>
    <p>
        <code>fusion:click="increment"</code> calls the compiled <code>increment()</code> method in the browser.
        The method changes <code>$count</code>, and only the parts of the view that read <code>$count</code>
        render again. This works because, when the view was compiled, every dynamic part recorded which properties
        it reads:
    </p>

    <x-docs.code src="fine-grained.blade.php" lang="blade" highlight="3" />

    @php
        $compare = [
            ['Livewire', 'the whole view, on the server', 'the new HTML against the page'],
            ['React, Vue', 'the component’s render function', 'the new virtual DOM against the last one'],
            ['Fusion', 'the expressions that read the property', 'nothing: each one updates its own node'],
        ];
    @endphp
    <x-docs.table :columns="['', 'A change runs', 'Then compares']" :rows="$compare" />

    <h2 id="a-server-call">What happens on a server call</h2>
    <p>A method marked <code>#[Server]</code> runs on the server. Each call is a single request:</p>

    <x-docs.steps>
        <x-docs.step title="The browser sends the signed state">
            <p>It sends the component's state exactly as the server signed it, the properties it has changed since, and the method with its arguments.</p>
        </x-docs.step>
        <x-docs.step title="The server checks everything">
            <ul>
                <li>The state is one the server signed, for this session and this user, and it hasn't been changed.</li>
                <li>The page's middleware (<code>auth</code>, <code>can</code>, ...) still lets the visitor in.</li>
                <li>Every changed property is public, isn't <code>#[Locked]</code>, has its declared type, and passes its <code>#[Validate]</code> rules.</li>
                <li>The method is a <code>#[Server]</code> method, and each argument has its parameter's type.</li>
            </ul>
        </x-docs.step>
        <x-docs.step title="The method runs">
            <p>It runs like any other Laravel code, with queries, mail, the session and the container. Models are always read again from the database, never taken from the browser.</p>
        </x-docs.step>
        <x-docs.step title="The browser renders what changed">
            <p>The response holds the new signed state, along with any events, redirects or messages. Only the parts of the view that read a changed property render again.</p>
        </x-docs.step>
    </x-docs.steps>

    <x-docs.callout type="warning" title="The browser can send anything">
        <p>Anyone can call your endpoint without using the page. An unlocked property can arrive with any value of its type. So check whatever a <code>#[Server]</code> method relies on, with <code>#[Validate]</code> rules or <code>$this-&gt;validate()</code>.</p>
    </x-docs.callout>

    <h2 id="navigation">Navigation</h2>
    <p>
        A link with <code>fusion:navigate</code> changes the page without a full reload. Laravel routes the visit
        as usual, with its middleware, bindings and redirects, and the browser shows the new page in place of the
        old one. The first visit to any URL always gets the server's complete HTML. These docs work this way.
    </p>

    <h2 id="production">In production</h2>
    <p>
        <code>fusion:build</code> compiles every component, minifies it with esbuild, and publishes versioned files
        to <code>public/fusion</code>. The web server sends these files without PHP, and browsers cache them for a
        year. Each page is in a file of its own, which loads the first time someone visits it. The files hold
        views and browser methods, never data. The state travels with each response.
    </p>

    <x-docs.cards>
        <x-docs.card href="/docs/components" title="Components" icon="browser" runs="both">Write classes and views, and learn where each part runs.</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server" runs="server">See every check a server call goes through.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

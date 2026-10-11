<x-docs.page
    lead="Nitro is a full-stack framework for Laravel. You write components and pages as a PHP class and a Blade view, just as you write Laravel code today, and Nitro compiles them to JavaScript that runs in the browser."
>
    <h2 id="what-nitro-does">What Nitro does</h2>
    <ul>
        <li><strong>The server renders the first page.</strong> Blade renders it, so it appears quickly and search engines can read all of it.</li>
        <li><strong>The browser takes over from there.</strong> Clicks, typing, filtering and re-rendering all happen in the page, without a request.</li>
        <li><strong>The server is one attribute away.</strong> When a method needs the database, mail or the session, mark it <code>#[Server]</code>. It then runs on the server, with the component's signed state.</li>
        <li><strong>Rendering is fine-grained.</strong> A change updates only the parts of the page that show it. There is no virtual DOM and no HTML diffing.</li>
    </ul>

    <x-docs.example component="counter" title="A component" source="#a-component" />

    <h2 id="a-component">A first component</h2>
    <p>
        The counter above is a class and a view. The <code>increment()</code> method runs in the browser, so
        clicking it doesn't send anything to the server. The <code>save()</code> method is marked
        <code>#[Server]</code>, so it runs on the server. It keeps the count in the session and sends the new
        state back. When the page loads again, <code>mount()</code> reads the count back, so it survives a reload.
        Open <strong>Compiled</strong> to see the JavaScript that Nitro makes from them.
    </p>

    <x-docs.pair class="app/Nitro/Components/Counter.php" view="resources/views/nitro/components/counter.blade.php" component="counter" />

    <x-docs.callout type="note" title="This demo saves to the session">
        <p>So that the example works for every visitor, without an account or a database, <code>save()</code> keeps the count in your session. Your application would save it to the database in the same way. The call to the server, the validation and the new state that comes back all stay the same.</p>
    </x-docs.callout>

    <p>You can place the component in any Blade view with its tag:</p>

    <x-docs.code src="place-counter.blade.php" lang="blade" file="any view" />

    <h2 id="where-code-runs">Where your code runs</h2>
    <p>
        Every part of a component runs in one place. If you put code in the wrong place, Nitro tells you. For
        example, a browser method that queries the database fails the build, and the error names the file and
        line.
    </p>

    @php
        $places = [
            ['mount(), boot(), hydrate(), dehydrate()', 'On the server, when the component is created or called.', 'server'],
            ['#[Server] methods', 'On the server, when the browser calls them with the signed state.', 'server'],
            ['#[Html] methods', 'On the server, whenever it sends the state: HTML for the view to place.', 'server'],
            ['All other methods, #[Computed], updated*()', 'In the browser, compiled to JavaScript.', 'browser'],
            ['The view', 'On the server for the first render, then in the browser.', 'both'],
        ];
    @endphp
    <x-docs.api-table :columns="['Code', 'Runs']" :rows="$places" />

    <x-docs.callout type="tip" title="Methods the browser never reaches are never compiled">
        <p>A private helper that you call only from <code>mount()</code> or from <code>#[Server]</code> methods can use anything PHP can, such as queries, services and the clock.</p>
    </x-docs.callout>

    <h2 id="requirements">Requirements</h2>
    <ul>
        <li>PHP 8.3 or higher</li>
        <li>Laravel 13</li>
        <li>Node.js and esbuild, for production builds (<code>nitro:build</code>) only</li>
    </ul>
    <p>
        Nitro's browser versions of Laravel's helpers (<code>Str::</code>, <code>route()</code>, <code>__()</code>)
        follow Laravel 13, so earlier Laravel versions are not supported. Nitro uses only Laravel's public APIs.
        It can also run on the same page as Livewire, because its tags, attributes, scripts and endpoints all use
        the <code>nitro:</code> prefix.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/installation" title="Installation" icon="bolt">Add Nitro to a Laravel application.</x-docs.card>
        <x-docs.card href="/docs/quickstart" title="Quickstart" icon="arrow">Build a todo list with a component, its view and a server method.</x-docs.card>
        <x-docs.card href="/docs/how-it-works" title="How Nitro works" icon="book">Learn what the compiler does, and what happens on the first render and on a click.</x-docs.card>
        <x-docs.card href="/docs/components" title="Components" icon="browser" runs="both">Write classes and views, and learn where each part runs.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

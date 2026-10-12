<x-docs.page
    lead="In development, Nitro adds an overlay to every page: the components on it and their state, each request they send and how long the server took, the page's data, the stores, and the errors. It is never sent in production."
>
    <p>
        Open any page of your app with <code>APP_DEBUG=true</code> and a small badge sits in the bottom-left corner:
        <strong>N</strong> and the number of components on the page, with a red count when something failed. Click it,
        and a drawer opens at the bottom of the window. There is nothing to install or turn on:
        <code>@@nitroScripts</code> adds it in development.
    </p>

    <h2 id="tabs">What the overlay shows</h2>

    @php
        $tabs = [
            ['Components', 'Every component on the page, with its id. Point at a row to outline the component in the page; click it to see its state, as the browser holds it'],
            ['Requests', 'Each `#[Server]` call, reload and upload: the component, the method, the status, the total time, the time on the server and in the database, and the size of the answer. The latest hundred are kept'],
            ['Page', 'The URL, the layout, and the size of the page\'s data: each component\'s state and the globals, so you can see what makes a page heavy'],
            ['Stores', 'Each store made in this tab, and its values as they change'],
            ['Errors', 'What failed in the browser: a call, a render, a handler, with its message (the `error` hook). The badge counts them'],
        ];
    @endphp
    <x-docs.table :columns="['Tab', 'Shows']" :rows="$tabs" />

    <p>
        The overlay lives in a shadow root, so your CSS never reaches it and its CSS never reaches your page. It is a
        <a nitro:navigate href="/docs/extending#plugins">plugin</a> on Nitro's public runtime, like any you could
        write, and it watches the page without changing it.
    </p>

    <x-docs.callout type="tip" title="Slow page? Look at Requests and Page">
        <p>A call that spends most of its time in the database needs a query looked at, or <a nitro:navigate href="/docs/caching">caching</a>. A page whose data is large sends a model or a list the view doesn't use: keep only the fields it shows, as <a nitro:navigate href="/docs/arrays-and-models#choosing">Arrays and models</a> explains.</p>
    </x-docs.callout>

    <h2 id="on-and-off">Turning it on and off</h2>
    <p>The overlay follows <code>APP_DEBUG</code>. To choose yourself, set <code>devtools</code> in <code>config/nitro.php</code>:</p>

    <x-docs.code src="devtools-config.php" />

    <ul>
        <li><strong><code>null</code></strong> (the default): on in development, off in production, as <code>APP_DEBUG</code> says.</li>
        <li><strong><code>false</code></strong>: never, even in development. For a screen recording or a demo.</li>
        <li><strong><code>true</code></strong>: always. Keep it for a staging server only: on a public site every visitor would get it.</li>
    </ul>
    <p>
        When it is off, <code>@@nitroScripts</code> leaves its script out of the page, and its URL under
        <code>/_nitro</code> answers 404: the overlay's code never leaves the server.
    </p>

    <h2 id="server-timing">Server-Timing</h2>
    <p>
        While the overlay is on, every response from your app carries a <code>Server-Timing</code> header: the
        time the request took on the server, and the part of it spent in the database. The overlay's Requests tab
        reads it, and so do the browser's own developer tools: open the Network tab, pick a request, and look at
        Timing.
    </p>

    <x-docs.code src="server-timing.txt" lang="ini" />

    <p>Your own scripts can read it too, through the browser's Performance API:</p>

    <x-docs.code src="devtools-timing.js" lang="js" />

    <p>
        <code>nitro</code> is the whole request on the server, from the middleware Nitro adds to the response;
        <code>db</code> is the time all its queries took, on every connection. With the overlay off, the header isn't
        sent.
    </p>

    <h2 id="names">Names in a build</h2>
    <p>
        After <code>php artisan nitro:build</code>, components, methods and pages go by short aliases
        (<a nitro:navigate href="/docs/production">Building for production</a>), and the overlay shows those. To see
        your own names while you work, run <code>php artisan nitro:clear</code>: without a build, Nitro compiles
        each component as you change it, under its real name.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/testing" title="Testing" icon="code">Test methods as plain PHP, and what a page sends the browser.</x-docs.card>
        <x-docs.card href="/docs/hooks" title="Hooks" icon="code">error, beforeRequest and the runtime's other moments.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

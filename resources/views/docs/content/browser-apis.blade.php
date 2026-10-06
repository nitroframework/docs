<x-docs.page
    lead="Fusion::browser() gives your methods the browser's own APIs, written in PHP. You can use the clipboard, local and session storage, a canvas to draw on, and WebSockets."
>
    <p>
        Some things only exist in the browser. <code>Fusion::browser()</code> lets your browser methods use them
        from PHP. Fusion checks what you write when it builds the bundle, and compiles it to the browser's own
        calls. The bundle only includes the APIs your application uses. On the server,
        <code>Fusion::browser()</code> throws an exception.
    </p>

    <x-docs.example component="browser-demo" title="Storage, the clipboard and a canvas" source="#the-component" />

    <p>
        Type a note, then reload the page. The note was saved in this browser's local storage, and
        <code>mounted()</code> reads it back. Try copying it to the clipboard. When you move the sliders, the chart
        is drawn again on the canvas.
    </p>

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Fusion/Components/BrowserDemo.php" view="resources/views/fusion/components/browser-demo.blade.php" component="browser-demo" />

    <h2 id="apis">Available APIs</h2>

    @php
        $apis = [
            ['`clipboard()`', '`write($text, $then)` and `read($then)`. They work on https pages and on localhost'],
            ['`storage()`, `session()`', 'localStorage and sessionStorage: `get($key, $default)`, `set($key, $value)`, `has($key)` and `forget($key)`. Values are stored as JSON'],
            ['`canvas($ref)`', 'The 2D context of a `<canvas fusion:ref="...">`, with the context\'s own method names (`fillStyle`, `fillRect`, `arc`, `fillText`, ...). `size($width, $height)` sets its size in CSS pixels, scaled for the screen'],
            ['`socket($url)`', 'A WebSocket, one per URL and component: `onMessage($then)`, `onOpen($then)`, `onClose($then)`, `send($data)` and `close()`. JSON messages arrive as arrays. The socket reconnects after a drop, and closes when the component leaves the page'],
        ];
    @endphp
    <x-docs.table :columns="['API', 'Methods']" :rows="$apis" />

    <p>
        Callbacks are closures. When a callback changes a property, the component renders again as it does for
        any other change, just like <code>$this-&gt;copied = true</code> in the example above.
    </p>

    <h2 id="sockets">Using WebSockets</h2>
    <x-docs.code src="browser-socket.php" runs="browser" />

    <h2 id="from-a-view">Using an API from a view</h2>
    <p>
        <code>fusion:ref</code> gives an element a name that <code>canvas()</code> can use, and
        <code>fusion:init</code> calls a method once the element appears. An event handler in a view can also
        call an API directly:
    </p>

    <x-docs.code src="browser-view.blade.php" lang="blade" />

    <x-docs.callout type="note" title="What stays in the browser">
        <p>Storage and the clipboard belong to the visitor's browser, and the server never sees them. To send something to the server, pass it to a <code>#[Server]</code> method.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/rendering" title="Rendering" icon="browser" runs="browser">Learn how the browser updates only what changed.</x-docs.card>
        <x-docs.card href="/docs/methods" title="Methods" icon="book">Write the browser methods these APIs are called from.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

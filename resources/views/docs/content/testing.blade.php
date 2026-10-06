<x-docs.page
    lead="A component is a PHP class, so you test its methods like any other PHP: create it, call a method, and assert on the result. To check what a page sends the browser, use assertFusion()."
>
    <h2 id="methods">Testing methods as plain PHP</h2>
    <p>
        A browser method is ordinary PHP that Fusion also compiles for the browser, and both versions give the
        same results. That means you can test it with PHPUnit directly, without a browser. This test checks the
        <a href="/docs/methods">cart</a> from these docs:
    </p>
    <x-docs.code src="testing-methods.php" runs="browser" />

    <p>
        A <code>#[Server]</code> method runs on the server, with your session, your user and your database. In a
        test, you call it like any other method:
    </p>
    <x-docs.code src="testing-server.php" runs="server" />

    <h2 id="pages">Testing pages</h2>
    <p>
        <code>assertFusion()</code> reads the page from a response, whether the page was rendered in full or sent as
        the answer to a visit. You can then assert on its name and its state. Use dot notation for keys.
    </p>
    <x-docs.code src="testing-page.php" />

    @php
        $asserts = [
            ['`page($name)`', 'The page is the one with this name (`pages::orders.index`)'],
            ['`has($key, $count)`', 'The state has the key. With a count, it is an array with that many items'],
            ['`missing($key)`', 'The state doesn\'t have the key, so it never reaches the browser'],
            ['`where($key, $expected)`', 'The value is the one given, or passes the given closure'],
            ['`deferred(...$properties)`', 'The page leaves these properties for later'],
            ['`notDeferred()`', 'The page leaves nothing for later'],
            ['`state($key)`', 'Returns the state, or one value of it'],
        ];
    @endphp
    <x-docs.table :columns="['Method', 'Asserts']" :rows="$asserts" />

    <p>To write your own assertions, <code>fusionState()</code> returns the state itself:</p>
    <x-docs.code src="testing-state.php" />

    <x-docs.callout type="tip" title="What the browser sees">
        <p>The state is exactly what the browser receives. A <code>missing()</code> assertion for each secret a page might hold is a cheap way to make sure it stays on the server.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/security" title="Security" icon="server">Learn what signed state protects, and what it doesn't.</x-docs.card>
        <x-docs.card href="/docs/limitations" title="Limitations" icon="book">See what works differently in the browser.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

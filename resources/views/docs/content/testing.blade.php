<x-docs.page
    lead="A component is a PHP class, so you test its methods like any other PHP: create it, call a method, and assert on the result. To check what a page sends the browser, use assertNitro()."
>
    <h2 id="methods">Testing methods as plain PHP</h2>
    <p>
        A browser method is ordinary PHP that Nitro also compiles for the browser, and both versions give the
        same results. That means you can test it with PHPUnit directly, without a browser. This test checks the
        <a href="/docs/methods">cart</a> from these docs:
    </p>
    <x-docs.code src="testing-methods.php" runs="browser" />

    <p>
        A <code>#[Server]</code> method runs on the server, with your session, your user and your database. In a
        test, you call it like any other method:
    </p>
    <x-docs.code src="testing-server.php" runs="server" />

    <h3 id="validation">Validation</h3>
    <p>
        <code>$this-&gt;validate()</code> in a <code>#[Server]</code> method checks the component's
        <code>#[Validate]</code> rules, and throws Laravel's <code>ValidationException</code> when one fails, as it
        does in a request. Assert that it is thrown, or read its messages:
    </p>
    <x-docs.code src="testing-validation.php" runs="server" />

    <h3 id="mount">Pages with mount()</h3>
    <p>
        A page's <code>mount()</code> takes what its route gives it, such as a bound model. Call it with the same, and
        assert on the properties it set:
    </p>
    <x-docs.code src="testing-mount.php" runs="server" />

    <h2 id="pages">Testing pages</h2>
    <p>
        <code>assertNitro()</code> reads the page from a response, whether the page was rendered in full or sent as
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
            ['`hasErrors(...$keys)`', 'There are validation messages for these properties (`form.email`), or any, when none are given'],
            ['`hasNoErrors()`', 'There are no validation messages'],
            ['`state($key)`', 'Returns the state, or one value of it'],
            ['`name()`', 'Returns the page\'s name'],
        ];
    @endphp
    <x-docs.table :columns="['Method', 'Asserts']" :rows="$asserts" />

    <p>To write your own assertions, <code>nitroState()</code> returns the state itself:</p>
    <x-docs.code src="testing-state.php" />

    <h3 id="visits">Visits and deferred properties</h3>
    <p>
        A <code>nitro:navigate</code> visit asks for the page's data rather than its HTML, and a page with
        <code>$this-&gt;defer()</code> properties is asked again for them once it shows. Send the same headers the
        browser does, and <code>assertNitro()</code> reads either answer:
    </p>
    <x-docs.code src="testing-visit.php" />

    <h2 id="calls">Calling a #[Server] method as the browser does</h2>
    <p>
        Calling a method on the class tests what it does. To test the call itself, with the signed state, the
        <code>#[Validate]</code> rules and the page's middleware, send it the way the browser does. Add
        <code>InteractsWithNitro</code> to your test, fetch the page, and call:
    </p>
    <x-docs.code src="testing-call.php" />

    <ul>
        <li><strong><code>callNitro($page, $method, $params, $updates)</code></strong> takes the page's signed state from the response, sets the properties in <code>$updates</code> as the browser would, and calls the method with <code>$params</code>. It goes through your test's own client, so <code>actingAs()</code> and the session hold.</li>
        <li><strong>A component on the page</strong> rather than the page itself: name it, <code>callNitro($page, 'save', component: 'posts.comment-form')</code>.</li>
        <li><strong>The answer</strong> reads with <code>assertNitro()</code>, as a page does: the new state, and <code>hasErrors()</code> when a rule refused it. A refused call still answers 200, with its messages.</li>
        <li><strong>A production build on your machine</strong> (after <code>nitro:build</code>) names methods and properties by aliases. <code>callNitro()</code> and <code>assertNitro()</code> translate them, so your tests keep your names.</li>
    </ul>

    <h2 id="build">Catching what can't run in the browser</h2>
    <p>
        A browser method or a view that uses something the browser can't run fails the build, with the file and
        line. Run the build in your CI, so such code never reaches production:
    </p>
    <x-docs.code code="php artisan nitro:build" lang="sh" />
    <p>
        It exits with an error when a component doesn't compile, and lists what it compiled when they all do:
        how many components, stores and pages, and what their views are written in.
    </p>

    <x-docs.callout type="tip" title="What the browser sees">
        <p>The state is exactly what the browser receives. A <code>missing()</code> assertion for each secret a page might hold is a cheap way to make sure it stays on the server.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/security" title="Security" icon="server">Learn what signed state protects, and what it doesn't.</x-docs.card>
        <x-docs.card href="/docs/limitations" title="Limitations" icon="book">See what works differently in the browser.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

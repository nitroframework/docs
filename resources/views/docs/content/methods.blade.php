<x-docs.page
    lead="A component's methods run in the browser. A click changes the state and the page at once, without a request. Only the methods you mark #[Server] go to the server."
>
    <p>
        You write methods the same way you write any PHP method. Nitro compiles them to JavaScript, so a click, a
        keystroke or a form submission runs your code right there in the browser. The view then renders again with
        whatever changed. Everything in the cart below happens without the server.
    </p>

    <x-docs.example component="cart" title="A cart, in the browser" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        <code>add()</code> and <code>remove()</code> change <code>$items</code>. <code>subtotal()</code> and
        <code>delivery()</code> are marked <code>#[Computed]</code>. <code>updatedPostcode()</code> runs after the
        postcode field changes. Open <strong>Compiled</strong> to see the JavaScript that each one becomes.
    </p>

    <x-docs.callout type="warning" title="The browser previews, the server decides">
        <p>The totals here are only a preview for the visitor, because anything the browser sends can be changed. Work out any prices and totals that money depends on again on the server, from the database, in the <code>#[Server]</code> method that takes the order.</p>
    </x-docs.callout>

    <x-docs.pair class="app/Nitro/Components/Cart.php" view="resources/views/nitro/components/cart.blade.php" component="cart" />

    <h2 id="calling-methods">Calling methods from the view</h2>
    <p>
        An event attribute names a method, or calls it with arguments. The arguments are expressions from the view,
        such as the loop's <code>$i</code>. Actions like <code>$set</code> and <code>$toggle</code> change a
        property without a method of your own.
    </p>

    <x-docs.code src="method-call.blade.php" lang="blade" />

    <p>
        Any DOM event works, with modifiers such as <code>.prevent</code> and <code>.enter</code>. See
        <a nitro:navigate href="/docs/directives">Directives</a> for the full list.
    </p>

    <h2 id="computed">Computing values</h2>
    <p>
        You read a <code>#[Computed]</code> method as if it were a property, as <code>$this-&gt;subtotal</code>, both
        in the class and in the view. Nitro works it out once and keeps the result until the state changes. A
        computed method takes no parameters. It isn't part of the state, so it's never sent anywhere.
    </p>

    <x-docs.callout type="tip" title="Compute values instead of storing them">
        <p>A total, a filtered list or a count is better computed than kept in a property. It always matches the state, and the state stays small.</p>
    </x-docs.callout>

    <h2 id="updated-hooks">Reacting to changes</h2>
    <p>
        <code>updatedPostcode($value)</code> runs in the browser after <code>nitro:model</code> or
        <code>$set</code> changes <code>$postcode</code>. <code>updated($property, $value)</code> runs after any such
        change. The cart uses it to tidy what was typed. Type <code>sw1a   1aa</code> in the postcode field and
        leave it to see the result.
    </p>

    <h2 id="helpers">Helper methods</h2>
    <p>Every component has these methods:</p>

    @php
        $helpers = [
            ['`$this->reset(\'prop\', ...)`', 'Puts properties back to their defaults'],
            ['`$this->js(\'...\')`', 'Runs JavaScript after the next render, with `$nitro`, `$refs` and `$el`'],
            ['`$this->dispatch(\'event\', ...)`', 'Dispatches an event to other components (see Events)'],
        ];
    @endphp
    <x-docs.table :columns="['Call', 'What it does']" :rows="$helpers" />

    <h2 id="php-in-the-browser">PHP in the browser</h2>
    <p>
        The compiled code behaves the way PHP does. Arrays are values, integers stay integers, and functions such as
        <code>array_splice()</code>, <code>preg_replace()</code> and <code>strtoupper()</code> give PHP's results.
        You can use operators, casts, and PHP's string, array, math, ctype, URL and <code>preg_*</code> functions, as
        well as 54 of Laravel's <code>Str::</code> helpers. All of them are tested against PHP and Laravel.
    </p>
    <p>
        Code that can't run in a browser, such as a facade, a model query, <code>new</code> or a function the
        browser doesn't have, fails the build. The error names the file and line and tells you what to do, so you
        find out before your visitors do. Move that code to a
        <a nitro:navigate href="/docs/server-methods">server method</a>.
    </p>

    <h2 id="pagination">Paginating and sorting</h2>
    <p>
        The <code>Nitro\Concerns\WithPagination</code> and <code>WithSorting</code> traits page and sort an
        array in the browser:
    </p>

    <x-docs.code src="pagination.php" file="app/Nitro/Components/Posts.php" runs="browser" highlight="6,17" />
    <x-docs.code src="pagination.blade.php" lang="blade" />

    <ul>
        <li><code>paginate()</code> returns <code>items</code>, <code>page</code>, <code>pages</code>, <code>total</code>, <code>from</code> and <code>to</code>. You move between pages with <code>gotoPage()</code>, <code>previousPage()</code>, <code>nextPage()</code> and <code>resetPage()</code>, and the page number is kept in the query string.</li>
        <li><code>sorted()</code> works with <code>sortBy('name')</code>, which reverses the order when you call it again, and with <code>sortIcon('name')</code>.</li>
        <li>Call <code>resetPage()</code> when a filter changes, so that a new search starts from the first page.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Use the database, mail and anything else that needs the server.</x-docs.card>
        <x-docs.card href="/docs/directives" title="Directives" icon="bolt">Handle events, with modifiers, actions and nitro: attributes.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

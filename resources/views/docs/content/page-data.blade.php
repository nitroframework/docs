<x-docs.page
    lead="A page loads its data from its route, and Nitro gives you tools to shape that. You can load slow data after the page shows, reload some properties, merge and scroll lists, share data with every component, and flash data once."
>
    <p>
        A page loads its data in <code>mount()</code>, on the server, from its route. The tools on this page
        control what to load later, what to load again, and how new data combines with what the page already has.
        Shared data and flash data work in components too.
    </p>

    <x-docs.example component="flash" title="Flash data from a server method" source="#flash" />

    <h2 id="deferred">Deferring slow properties</h2>
    <p>A page can show first and load its slow data right after:</p>

    <x-docs.code src="defer.php" runs="server" highlight="5" />
    <x-docs.code src="defer.blade.php" lang="blade" />

    <p>
        Nitro renders the page without the deferred properties, and the page then asks its own URL for them. The
        page stays usable while they load, and anything that changes in the meantime is kept. Use
        <code>@@deferred</code> without names to wait for every deferred property.
    </p>

    <h2 id="reloads">Reloading properties</h2>
    <p>
        A page can reload some of its properties from its route. Call <code>$this-&gt;reload('orders')</code> in a
        method or a <code>#[Server]</code> method, or <code>$reload('orders')</code> in a handler. The page asks its
        URL again and takes the named properties from the answer, while the other properties keep their values in
        the browser. Without names, every property is reloaded, including what the visitor typed.
    </p>
    <p>A reload runs <code>mount()</code> again. Use <code>$this-&gt;wants()</code> to skip the work a reload doesn't need:</p>

    <x-docs.code src="reload.php" runs="server" highlight="5,10,14" />

    <p>
        The answer signs the reloaded properties, so <code>#[Locked]</code> properties reach the next
        <code>#[Server]</code> call exactly as the server gave them.
    </p>

    <h2 id="merging">Merging and scrolling lists</h2>
    <p>
        When a property is reloaded, you can merge the new value into the one the page already has, instead of
        replacing it. The first render and a visit still set it as usual.
    </p>

    <x-docs.code src="merge.php" runs="server" />

    @php
        $merges = [
            ['`$this->merge()`', 'Appends the new items. `->prepend()` puts them first, and `->append(\'data\')` merges the list at a key'],
            ['`$this->deepMerge()`', 'Merges arrays key by key, all the way down. Lists are appended'],
            ['`$this->scroll()`', 'Takes a paginator (`paginate()`, `simplePaginate()` or `cursorPaginate()`), and the property holds its items. `$loadMore(\'posts\')` asks for the next page and appends it, and `$this->hasMore(\'posts\')` tells you whether there is one'],
            ['`->matchOn(\'id\')`', 'Replaces an item that has the same id, instead of adding it again'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Does']" :rows="$merges" />

    <x-docs.code src="scroll.blade.php" lang="blade" highlight="6" />

    <p>
        Each closure runs only when the request wants its property. The merge rule travels with the signed reload,
        so the next <code>#[Server]</code> call merges the same way, and a <code>#[Locked]</code> list keeps what
        was loaded.
    </p>

    <x-docs.callout type="tip" title="Scroll on the server, filter in the browser">
        <p>Use scroll properties for long lists that the server pages through. For a list of a few hundred rows, send it whole and filter it in the browser with a <code>#[Computed]</code> method. Filtering then needs no request.</p>
    </x-docs.callout>

    <h2 id="shared">Sharing data with every component</h2>
    <p>
        <code>Nitro::share()</code> gives every component and page the same data. Call it in a middleware, so it
        runs on every request:
    </p>

    <x-docs.code src="share.php" file="app/Http/Middleware/ShareNitroData.php" runs="server" />
    <x-docs.code src="share.blade.php" lang="blade" />

    <ul>
        <li>Read shared data with <code>$this-&gt;shared()</code>, in views and in methods. It takes dot notation and a default.</li>
        <li>The data is sent with the page, with each visit and with each <code>#[Server]</code> answer. Closures are called when the data is read.</li>
        <li>Use <code>shareOnce()</code> and <code>Nitro::once()</code> for data that rarely changes. The browser keeps it across visits and calls, and the server doesn't send it again until it expires or you send it with <code>-&gt;fresh()</code>. Set the expiry with <code>-&gt;until()</code>, as seconds, an interval or a date. Once data is shared at the top level, under a key without dots.</li>
    </ul>

    <x-docs.callout type="danger" title="Everything shared is public">
        <p>Shared data is sent to the browser, so never share anything secret.</p>
    </x-docs.callout>

    <h2 id="flash">Flashing data</h2>
    <p>
        <code>Nitro::flash()</code> sends data with the next response only, such as a message after a save. The
        example above flashes a message from its <code>#[Server]</code> method, and its view shows the message with
        <code>$this-&gt;flashed()</code>.
    </p>

    <x-docs.pair class="app/Nitro/Components/Flash.php" view="resources/views/nitro/components/flash.blade.php" component="flash" />

    <p>
        Flash data goes with this request's page, visit or <code>#[Server]</code> answer. After a redirect, it goes
        with the page the redirect leads to. After that it is gone, and the back button doesn't bring it back. In
        the browser, the <code>flash</code> <a nitro:navigate href="/docs/hooks">hook</a> hears it, with the data in
        <code>flash</code> (and the <code>nitro:flash</code> event, in <code>event.detail.flash</code>).
        Flash data needs the session, so the request must run through the <code>web</code> middleware.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs with nitro:model, and validate them with #[Validate].</x-docs.card>
        <x-docs.card href="/docs/events" title="Events" icon="bolt">Let components talk to each other, and to Laravel broadcasting.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

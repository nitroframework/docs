<x-docs.page
    lead="When a method needs the server, mark it with #[Server]. It can then use the database, mail, the filesystem and anything else PHP can do. The browser calls it with the component's signed state and receives the new state back."
>
    <p>
        Most of a component runs in the browser. When a method needs the server, add the
        <code>#[Server]</code> attribute to it. Nothing else changes. Your view calls it the same way, and the
        method reads and changes the component's properties like any other method.
    </p>

    <x-docs.example component="username" title="A check on the server" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        When you type, <code>$name</code> changes in the browser. Clicking <strong>Check</strong> calls
        <code>check()</code>, which runs on the server. It validates the name, looks it up and sets
        <code>$result</code>. The <code>taken()</code> method is private, and only <code>check()</code> calls it,
        so Nitro never compiles it. Open <strong>Compiled</strong> and you'll see that it isn't there.
    </p>

    <x-docs.pair class="app/Nitro/Components/Username.php" view="resources/views/nitro/components/username.blade.php" component="username" />

    <h2 id="a-call">What happens during a call</h2>
    <x-docs.steps>
        <x-docs.step title="The browser sends the state">
            <p>It sends the component's state, which the server signed when it last sent it, along with what the browser changed since, the method's name and its arguments.</p>
        </x-docs.step>
        <x-docs.step title="The server checks it">
            <p>The server checks the signature and the method, which must be <code>#[Server]</code>. It also checks the types of what changed and of the arguments, and the <code>#[Validate]</code> rules of what changed. If a rule fails, the call stops here and the messages are in <code>$errors</code>.</p>
        </x-docs.step>
        <x-docs.step title="Your method runs">
            <p>Your method runs after <code>boot()</code> and <code>hydrate()</code>. Model properties are read again from the database first.</p>
        </x-docs.step>
        <x-docs.step title="The new state comes back">
            <p>After <code>dehydrate()</code>, the server signs the new state and sends it back. The browser then renders what changed.</p>
        </x-docs.step>
    </x-docs.steps>

    <h2 id="arguments">Passing arguments</h2>
    <p>
        Arguments come from the browser, so the server checks each one against its type. A parameter typed as a
        model or as a backed enum is resolved from what the browser sends. A parameter typed as any other class is
        resolved from the container.
    </p>

    <x-docs.code src="server-arguments.blade.php" lang="blade" />
    <x-docs.code src="server-arguments.php" runs="server" highlight="8,15,22" />

    @php
        $arguments = [
            ['A model', 'The record its key names, resolved as route model binding resolves one (its route key, or its own `resolveRouteBinding()`). You can also pass the row itself: `remove($post)`. A missing record answers 404, and a nullable `?Post` receives `null`.'],
            ['A backed enum', 'The case its value names. Any other value answers 403.'],
            ['Any other class', 'An instance resolved from the container. It takes nothing from the browser.'],
            ['`int`, `string`, `array`, ...', 'A value of that type. A value of another type answers 403.'],
        ];
    @endphp
    <x-docs.table :columns="['Parameter', 'Receives']" :rows="$arguments" />

    <x-docs.callout type="warning" title="Resolving a record doesn't authorize it">
        <p>The key comes from the browser, and anyone can send any key. Always check that the visitor may act on the record, for example with a policy and <code>Gate::authorize()</code>, or with a query scoped to the visitor.</p>
    </x-docs.callout>

    <p>
        If the browser could never fill a parameter, such as a variadic model, an abstract model or a pure enum,
        the build fails.
    </p>

    <h2 id="validation">Validating data</h2>
    <p>
        To validate the component's properties, call <code>$this-&gt;validate([...])</code>. When a rule fails,
        the method stops, and the messages are available in <code>$errors</code> for <code>@@error</code> in the
        view. If you call it without rules, it checks every property's <code>#[Validate]</code> rules. See
        <a nitro:navigate href="/docs/forms">Forms and validation</a> for more.
    </p>

    <h2 id="caching">Keeping a slow result</h2>
    <p>
        A <code>#[Server]</code> method that only loads data, such as a lookup or a search, can keep its result
        with <code>#[Cached]</code>: the next call with the same arguments and state gets it without running the
        method, until <code>Nitro::expire()</code> forgets it. See
        <a nitro:navigate href="/docs/caching">Caching</a>.
    </p>

    <h2 id="redirects">Redirecting</h2>
    <p>To send the browser to another page once the call is done, call <code>$this-&gt;redirect($url)</code>:</p>

    <x-docs.code src="server-redirect.php" runs="server" highlight="8" />

    <p>
        If you call <code>$this-&gt;redirect($url, navigate: true)</code>, the browser goes there the way a
        <code>nitro:navigate</code> link does, without a full reload. Nitro accepts only <code>http(s)</code>
        URLs and paths.
    </p>

    <h2 id="from-the-browser">Calling a server method from a browser method</h2>
    <p>
        A browser method can call a <code>#[Server]</code> method, but only as a statement. Its return value
        doesn't reach the browser, so the server method should change properties instead of returning a value.
    </p>

    <x-docs.code src="server-from-browser.php" runs="browser" highlight="4" />

    <h2 id="loading">Showing that a call is running</h2>
    <p>
        Add <code>nitro:loading</code> to an element to show it while a <code>#[Server]</code> call runs. With
        <code>.remove</code>, the element is hidden instead. With <code>.attr="disabled"</code> or
        <code>.class="..."</code>, an attribute or classes change instead. To react to one method only, add
        <code>nitro:target</code>.
    </p>

    <x-docs.code src="server-loading.blade.php" lang="blade" />

    <h3 id="loading-delay">Waiting before showing it</h3>
    <p>
        Most calls finish quickly, and a spinner that flashes for a moment is just noise. Add <code>.delay</code>,
        and the element changes only once the call has taken 200ms. Give it a time to wait longer or shorter.
        A call that ends sooner shows nothing.
    </p>

    <x-docs.code src="server-loading-delay.blade.php" lang="blade" />

    <ul>
        <li><strong>Any form can wait.</strong> Put <code>.delay</code> first: <code>.delay.remove</code>, <code>.delay.class="..."</code>, <code>.delay.class.remove="..."</code>, <code>.delay.attr="..."</code>.</li>
        <li><strong>A time in ms or s.</strong> <code>.delay.500ms</code>, <code>.delay.1s</code>. Without one, it waits 200ms.</li>
        <li><strong>A wrong modifier fails the build,</strong> naming the line, rather than doing nothing in the browser.</li>
    </ul>

    <p>
        The runtime also dispatches the <code>nitro:request</code> and <code>nitro:response</code> events around
        each call. You can show the progress bar during calls by setting <code>server_calls</code> in
        <code>config/nprogress.php</code>.
    </p>

    <h2 id="what-to-trust">What you can trust</h2>
    <ul>
        <li><strong>The state is signed.</strong> Nitro signs it with the application key, the session's secret and the logged-in user. A changed state, or one from another session or user, is refused.</li>
        <li><strong>Unlocked properties accept any value of their type.</strong> Add <code>#[Validate]</code> rules to the properties a server method relies on, or validate them in the method.</li>
        <li><strong><code>#[Locked]</code> means unchangeable, not current.</strong> Read anything that must be current, such as a balance or a permission, from the database in the method.</li>
        <li><strong>Every public property is sent to the browser.</strong> Keep secrets in protected or private properties.</li>
    </ul>
    <p>See <a nitro:navigate href="/docs/security">Security</a> for everything the endpoint refuses.</p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs, validate them, and show the errors.</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server" runs="server">Learn how the state is signed, and what the endpoint refuses.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

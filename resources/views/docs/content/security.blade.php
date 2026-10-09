<x-docs.page
    lead="Every #[Server] call carries the component's state, signed with the application key, the session's own secret and the logged-in user. The endpoint refuses anything the page could not have sent."
>
    <h2 id="refused">What the endpoint refuses</h2>
    <p>Nitro checks every request to its endpoint. It refuses these requests, with these status codes:</p>

    @php
        $refused = [
            ['A changed state, or a state made in another session or for another user. This includes another visitor\'s state, and one from before a logout, even an `Auth::logout()` that keeps the session', '419'],
            ['A state older than `nitro.state.lifetime`, when you have set one', '419'],
            ['A method that isn\'t `#[Server]`, a locked or unknown property, or a value or argument of the wrong type', '403'],
            ['An upload to anything other than an `Upload` or `#[Uploads]` property', '403'],
            ['A visitor who no longer passes the page\'s authorization middleware (`auth`, `can`, `verified`, ..., and your own middleware that extends them), or a page whose route no longer exists', '403'],
            ['A partial reload that was rendered for a different page than the component\'s', '403'],
        ];
    @endphp
    <x-docs.table :columns="['Refused', 'Status']" :rows="$refused" />

    <p>
        An upload reference is only valid in the session that uploaded the file. Redirects only go to http(s) URLs
        and paths, so <code>redirect('javascript:...')</code> throws an exception, and the browser refuses such a
        redirect too. The endpoint runs in the <code>web</code> middleware group, with sessions and CSRF protection.
    </p>

    <h2 id="what-the-browser-sees">What the browser can see</h2>
    <p>
        Every public property is part of the page's state, including <code>#[Locked]</code> ones. A model property
        sends its <code>toArray()</code>: attributes listed in <code>$hidden</code> are left out, but loaded relations
        are sent. Keep secrets in protected or private properties, or load them in the <code>#[Server]</code> method
        that needs them.
    </p>
    <x-docs.code src="security-secrets.php" highlight="10" />

    <p>
        An unlocked property accepts any value of its type from the browser. Its <code>#[Validate]</code> rules are
        checked before a <code>#[Server]</code> method runs (see <a href="/docs/properties">Properties</a>).
    </p>

    <h2 id="locked">Locked doesn't mean current</h2>
    <p>
        Signing stops the browser from changing a <code>#[Locked]</code> value. It doesn't stop the same visitor
        from sending an older state from their own session, as long as that state is still valid. So
        <code>#[Locked]</code> means a value can't be changed, not that it is up to date. When something must be
        current, such as a balance, a step that was paid for or a permission, read it from the database in the
        <code>#[Server]</code> method.
    </p>
    <x-docs.code src="security-locked.php" highlight="14" runs="server" />

    <h2 id="children">Trusting a child's props</h2>
    <p>
        A child component is created with the props its parent's view passes it, taken from the parent's state at
        that moment. During a <code>#[Server]</code> call, that state includes the browser's changes. This means a
        child's <code>mount()</code> can receive a value the browser chose, and a <code>#[Locked]</code> property set
        from it is only as trustworthy as its source. Pass children values the parent keeps <code>#[Locked]</code>,
        or check the value in the child's <code>mount()</code>.
    </p>

    <h2 id="state">Configuring sessions and lifetimes</h2>
    <x-docs.code src="security-state.php" />

    <p>
        When a call is refused with a 419, the page reloads with fresh state. To do something else instead, listen
        for the <code>nitro:expired</code> event and call <code>preventDefault()</code>:
    </p>
    <x-docs.code src="security-expired.js" lang="js" />

    <x-docs.callout type="note" title="Tested by forging requests">
        <p>Every refusal above is tested with hand-made requests, in every form a forger might try, and by fuzzing the endpoint with malformed requests. Each one is refused, nothing runs, and nothing answers with a 500 error.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Put the work that needs the server in #[Server] methods.</x-docs.card>
        <x-docs.card href="/docs/limitations" title="Limitations" icon="book">See what works differently in the browser.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

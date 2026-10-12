<x-docs.page
    lead="A component lives in two places: the server creates it and answers its #[Server] calls, and the browser runs it in between. Hooks let you run code at each step of that life, on the side where the step happens."
>
    <h2 id="overview">A component's life</h2>
    <x-docs.steps>
        <x-docs.step title="Created on the server">
            <p>The page renders: <code>boot()</code>, then <code>mount()</code> (or the tag's values into its properties), then the view, then <code>dehydrate()</code>. Its state is signed and sent with the HTML.</p>
        </x-docs.step>
        <x-docs.step title="Live in the browser">
            <p>The browser takes over the server's HTML and runs <code>mounted()</code>. From then on its methods and view run there; a change from the view runs <code>updated*()</code>.</p>
        </x-docs.step>
        <x-docs.step title="Called on the server">
            <p>Each <code>#[Server]</code> call rebuilds it from its signed state: <code>boot()</code>, <code>hydrate()</code>, the browser's changes checked and applied, the method, <code>dehydrate()</code>. The new state goes back, and the browser carries on.</p>
        </x-docs.step>
        <x-docs.step title="Gone">
            <p>When it leaves the page (an <code>@@if</code>, a removed item, a visit), <code>destroyed()</code> runs in the browser. So it does when another script takes its element out, as a dialog library closing a dialog: its listeners, polls and broadcasts stop with it. An element moved elsewhere has not left. To hide a component and keep it, hide it with CSS rather than remove it.</p>
        </x-docs.step>
    </x-docs.steps>

    <p>
        A component created in the browser (a new item in a loop, with no <code>mount()</code>) skips the first step:
        its properties come from its tag, and it starts at <code>mounted()</code>.
    </p>

    <h2 id="hooks">The hooks</h2>

    @php
        $hooks = [
            ['`boot()`', 'Server', 'Every request: on creation and on each `#[Server]` call, before anything else'],
            ['`mount(...)`', 'Server', 'Once, on creation. Takes the tag\'s or the route\'s values, and anything Laravel\'s container can give'],
            ['`hydrate()`', 'Server', 'Each `#[Server]` call, once the state is restored, before the browser\'s changes are applied'],
            ['`dehydrate()`', 'Server', 'Every request, last, before the state goes to the browser'],
            ['`exception($e)`', 'Server', 'A `#[Server]` method threw: handled, unless the hook throws it again'],
            ['`fallback($e)`', 'Server', 'The component failed, in production: what shows in its place (see Handling errors)'],
            ['`mounted()`', 'Browser, or `#[Server]`', 'Once the component is live in the page'],
            ['`updatingSearch($value)`', 'Browser', 'Before the view changes `$search`: `$this->search` still has the old value'],
            ['`updating($property, $value)`', 'Browser', 'Before the view changes any property, with its path'],
            ['`updatedSearch($value)`', 'Browser, or `#[Server]`', 'After the view changed `$search`'],
            ['`updatedFilters($value, $key)`', 'Browser, or `#[Server]`', 'After the view changed a key under `$filters`: its value, and the key'],
            ['`updated($property, $value)`', 'Browser, or `#[Server]`', 'After the view changed any property, with its full path (`filters.owner`)'],
            ['`rendered()`', 'Browser', 'After each render that changed the view'],
            ['`destroyed()`', 'Browser, or `#[Server]`', 'When the component leaves the page'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'Runs', 'When']" :rows="$hooks" />

    <h2 id="server-hooks">On the server</h2>

    <x-docs.code src="lifecycle-server.php" file="app/Nitro/Components/TeamMembers.php" />

    <ul>
        <li><strong><code>boot()</code></strong> is for what every request needs, such as a check that must pass on creation and on each call alike.</li>
        <li><strong><code>mount()</code></strong> sets the starting state. It runs once: a <code>#[Server]</code> call doesn't run it again, because the state comes from the browser, signed.</li>
        <li><strong><code>hydrate()</code></strong> sees the state as the server last sent it. The browser's changes are applied after it, then checked by <code>#[Validate]</code>; when a rule fails, the method doesn't run.</li>
        <li><strong><code>dehydrate()</code></strong> runs once per request, whatever happened before it, so it is the place to tidy the state on its way out.</li>
    </ul>

    <h2 id="browser-hooks">In the browser</h2>
    <p>These hooks are compiled to JavaScript like any browser method, so they run with no request:</p>

    <x-docs.code src="lifecycle-browser.php" runs="browser" />

    <ul>
        <li><strong>The property hooks run for the view's changes</strong>: <code>nitro:model</code>, <code>$set()</code>, and in a JavaScript view, <code>set()</code>, <code>v-model</code> or a binding. A method that assigns a property doesn't run them: the method already knows what it changed.</li>
        <li><strong><code>updating*()</code> runs before the change</strong>, so <code>$this->search</code> still holds the old value and the hook gets the new one; <code>updated*()</code> runs after it. A property's own hook runs first, then <code>updating()</code> or <code>updated()</code>.</li>
        <li><strong>A hook names its property in StudlyCase</strong>: <code>updatedFirstName()</code> is <code>$firstName</code>'s, or <code>$first_name</code>'s. A method whose name names no property, such as <code>updatedAt()</code>, is an ordinary method.</li>
        <li><strong>For a key under an array</strong>, <code>updatedFilters()</code> gets the new value of that key, and the key's path (<code>status</code>); <code>updated()</code> gets the full path (<code>filters.status</code>).</li>
        <li><strong><code>rendered()</code> runs after each render that changed the view</strong>, not the first: that is <code>mounted()</code>. What it changes renders too, without running it again, so it can't loop. Use it to keep a third-party widget in step with the view.</li>
        <li><strong>An error in a hook</strong> is reported in the console, naming the component; the component carries on.</li>
    </ul>

    <h3 id="server-hooks-in-the-browser">When a hook needs the server</h3>
    <p>
        Mark <code>updated*()</code>, <code>mounted()</code> or <code>destroyed()</code> <code>#[Server]</code> and it runs
        on the server: the browser makes the change, then calls the hook, sending the change along. It is an ordinary
        <code>#[Server]</code> method, with its rules and checks:
    </p>

    <x-docs.code src="lifecycle-server-hook.php" runs="server" />

    <p>
        Pair it with <code>nitro:model.debounce</code>, so it runs once the visitor stops typing rather than on every
        key. Two hooks stay in the browser, and <code>#[Server]</code> on them is an error that says so:
        <code>updating*()</code> runs before the change, which can't wait for a request, and <code>rendered()</code>
        runs after every render, which would make each render a request. Have them call a <code>#[Server]</code>
        method instead.
    </p>

    <h3 id="exception">When a server method throws</h3>
    <p>
        <code>exception()</code> runs on the server when a <code>#[Server]</code> method throws. The call then answers
        normally, with the state as the hook left it, so the view can say what went wrong. To let the error through
        after all, throw it again. A failed <code>validate()</code> isn't an exception here: its messages go to
        <code>$errors</code> as always.
    </p>

    <x-docs.code src="lifecycle-exception.php" runs="server" />

    <p>
        An error the hook throws again, or one in a component without the hook, shows the component's fallback in
        production. See <a nitro:navigate href="/docs/errors">Handling errors</a>.
    </p>

    <x-docs.callout type="warning" title="Browser hooks protect nothing">
        <p><code>updated*()</code> runs in the browser, so a visitor can skip it and send any value of a property's type. Keep what must hold on the server in <code>#[Validate]</code> rules, <code>#[Locked]</code> properties and <code>#[Server]</code> methods. See <a nitro:navigate href="/docs/security">Security</a>.</p>
    </x-docs.callout>

    <h2 id="after-render">After the next render</h2>
    <p>
        To run JavaScript once the view has rendered, as a hook would, call <code>$this-&gt;js()</code>. The snippet can
        use <code>$nitro</code> (the component), <code>$refs</code> (its elements marked with <code>nitro:ref</code>)
        and <code>$el</code> (its root element):
    </p>

    <x-docs.code src="component-js.php" runs="browser" highlight="7" />

    <p>
        From a <code>#[Server]</code> method, it runs once the answer has rendered. The snippet is code: never build it
        from what a visitor typed.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">What happens during a call, step by step.</x-docs.card>
        <x-docs.card href="/docs/properties" title="Properties" icon="book">The state that travels between the two sides.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

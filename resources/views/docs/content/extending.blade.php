<x-docs.page
    lead="Fusion has four ways for you to add to it: your own fusion: attributes, plugins in the browser, features that run around every component on the server, and attributes that work as features."
>
    <p>
        Each one is small on its own. Use your own attributes for behaviour in the page, such as a tooltip or a
        textarea that grows. Use plugins to listen to the runtime in the browser. Use features and attribute classes
        to run code around your components on the server.
    </p>

    <h2 id="attributes">Adding your own attributes</h2>
    <p>
        A <code>fusion:</code> attribute of your own takes two steps. First, list its name in
        <code>config/fusion.php</code>, so the compiler accepts it:
    </p>

    <x-docs.code src="extending-attributes-config.php" />

    <p>
        Then register a directive with the same name in your JavaScript. The directive receives the element, the
        attribute's value and its modifiers, and it can return a function that cleans up:
    </p>

    <x-docs.code src="resources/js/autosize.js" lang="js" file="resources/js/autosize.js" />
    <x-docs.code src="extending-attribute-view.blade.php" lang="blade" />

    <x-docs.example component="reply-box" title="fusion:autosize" source="#attributes" />

    <p>Type a few lines into the box. It grows with your text, up to eight lines, and then it scrolls.</p>

    <ul>
        <li><strong>When it runs.</strong> The directive runs when its element appears. It runs again when the attribute's value or modifiers change, and not on other renders. The value is rendered like any attribute, so it can contain <code>@{{ }}</code>.</li>
        <li><strong>What it receives.</strong> <code>el</code> is the element, <code>value</code> is the attribute's value as a string, and <code>modifiers</code> is a list of the words after its name, such as <code>.top</code> in <code>fusion:tooltip.top</code>. To pass data, use <code>@@json(...)</code> in the value.</li>
        <li><strong>Cleaning up.</strong> The function the directive returns runs before the directive runs again, and when the element or its component leaves the page.</li>
        <li><strong>Mistakes are caught.</strong> A <code>fusion:</code> attribute that isn't listed fails the build. You can't list a name Fusion uses itself, such as <code>click</code> or <code>model</code>.</li>
    </ul>

    <h3 id="registering">Registering a directive</h3>
    <p>
        A script that runs after <code>@@fusionScripts</code> can call <code>Fusion.directive()</code> directly. A
        script that runs before it, such as a Vite module in the page's <code>&lt;head&gt;</code>, should register in
        a <code>fusion:starting</code> listener, as the example above does. Fusion fires that event on
        <code>document</code> just before any component starts. A directive you register later still runs on the
        elements already on the page.
    </p>

    <h3 id="talking-to-components">Talking to the component</h3>
    <p>
        A directive also receives <code>component</code>. Call <code>component.dispatch()</code> to send an event, just
        as <code>$this-&gt;dispatch()</code> does, and any <code>#[On]</code> method can listen for it:
    </p>

    <x-docs.code src="extending-dispatch.js" lang="js" />
    <x-docs.code src="extending-dispatch.php" runs="browser" />

    <h2 id="plugins">Writing plugins</h2>
    <p>
        A plugin listens to Fusion's runtime in the browser: its events, by name, with <code>on()</code>. Pass a function to <code>Fusion.use()</code>, and Fusion
        calls it once with the plugin API:
    </p>

    <x-docs.code src="extending-plugin.js" lang="js" />

    @php
        $events = [
            ['`component`', 'A component started in the page: `{ name, el, dispatch(event, ...params) }`'],
            ['`render`', 'The same component, after each render'],
            ['`store`', 'A store was made in this tab: `{ name, persist, sync, get(property), set(property, value), onChange(listener) }`'],
            ['`request`', 'Before a `#[Server]` call or a partial reload: `{ component, method, headers }`'],
            ['`response`', 'When the answer arrives: `{ component, method, status }`, with `0` when none arrived'],
        ];
    @endphp
    <x-docs.table :columns="['Event', 'Called with']" :rows="$events" />

    <ul>
        <li><strong>Removing a listener.</strong> <code>on()</code> returns a function that removes the listener.</li>
        <li><strong>Late plugins catch up.</strong> A <code>component</code> or <code>store</code> listener also hears the components and stores already on the page.</li>
        <li><strong>Headers.</strong> A <code>request</code> listener can add headers, but it can't change Fusion's own, such as the CSRF token.</li>
        <li><strong>Store values</strong> are JSON-safe, in the form the server sends them. <code>set()</code> counts as the browser's own change, so the server checks it on the next call.</li>
        <li><strong>Errors are contained.</strong> A listener that throws is reported with <code>fusion:error</code>, and the other listeners still run.</li>
        <li><strong>Names are the browser's.</strong> In an obfuscated build, methods and properties go by their aliases.</li>
    </ul>

    <x-docs.callout type="tip" title="Fusion uses this API too">
        <p><code>#[Persist]</code> and <code>#[Sync]</code>, which keep a store's state and share it between tabs, are plugins built only on this API.</p>
    </x-docs.callout>

    <h2 id="features">Running code around every component</h2>
    <p>
        A feature runs on the server, around every component. Use one for things a single component's hooks can't
        do, such as auditing every <code>#[Server]</code> call or setting a tenant on every component. Extend
        <code>Nitro\Fusion\Feature</code> and override the hooks you need:
    </p>

    <x-docs.code src="extending-feature.php" file="app/Fusion/Features/AuditCalls.php" runs="server" />

    <p>Then list it in <code>config/fusion.php</code>:</p>

    <x-docs.code src="extending-feature-config.php" />

    @php
        $serverHooks = [
            ['`boot($component)`', 'On every request, when the component is created or restored'],
            ['`mounting($component)`', 'For a new component, before `mount()`'],
            ['`hydrate($component)`', 'On a `#[Server]` call, once the state is restored'],
            ['`updated($component, $changed)`', 'On a `#[Server]` call, once the browser\'s changes are set. Return `false` to stop the method from running'],
            ['`calling($component, $method, $arguments)`', 'Before a `#[Server]` method runs'],
            ['`called($component, $method, $result)`', 'After a `#[Server]` method returns'],
            ['`dehydrate($component)`', 'Before the state is sent to the browser, once per request'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'Runs']" :rows="$serverHooks" />

    <ul>
        <li><strong>Order.</strong> Each hook runs after the component's own method of the same name, such as <code>boot()</code>. Your features run after Fusion's own, so <code>updated()</code> can see what <code>#[Validate]</code> found in <code>$component-&gt;fusion()-&gt;errors</code>.</li>
        <li><strong>Services.</strong> The container makes each feature once per request, so its constructor can take services.</li>
        <li><strong>Stores</strong> run features too, since a store is a component.</li>
        <li><strong>Stopping a method.</strong> Every feature's <code>updated()</code> runs, even after one returns <code>false</code>. An error a feature adds to <code>$component-&gt;fusion()-&gt;errors</code> reaches the browser like a validation message.</li>
    </ul>

    <h2 id="attribute-classes">Writing attributes that work as features</h2>
    <p>
        A feature can also be an attribute that runs only where you place it. Extend
        <code>Nitro\Fusion\FeatureAttribute</code>, and <code>$this-&gt;target()</code> tells you the property or
        method it's on:
    </p>

    <x-docs.code src="extending-attribute-class.php" file="app/Fusion/Attributes/Throttle.php" runs="server" />
    <x-docs.code src="extending-attribute-use.php" file="app/Fusion/Components/Contact.php" highlight="4" runs="server" />

    @php
        $placements = [
            ['A `#[Server]` method', '`calling()` and `called()` run for that method only'],
            ['A property', '`updated()` runs only when the browser changed that property'],
            ['The class', 'Every hook runs'],
        ];
    @endphp
    <x-docs.table :columns="['Placed on', 'Its hooks']" :rows="$placements" />

    <ul>
        <li><strong>Browser methods are refused.</strong> A browser method never reaches the server, so an attribute class on one fails the build.</li>
        <li><strong>Order.</strong> Attribute classes run after the component's own hooks, and before <code>#[Validate]</code> and the features in <code>config/fusion.php</code>. So a property's <code>updated()</code> can tidy a value before it's validated.</li>
        <li><strong>One per component.</strong> Each component gets its own instance, made from the attribute's arguments rather than by the container.</li>
    </ul>

    <x-docs.callout type="note" title="Fusion's #[Url] is one">
        <p><code>#[Url]</code> is itself an attribute class: its <code>mounting()</code> hook reads the property's value from the query string.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/directives" title="Directives" icon="book">See the fusion: attributes Fusion has built in.</x-docs.card>
        <x-docs.card href="/docs/configuration" title="Configuration" icon="book">See every option in config/fusion.php.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

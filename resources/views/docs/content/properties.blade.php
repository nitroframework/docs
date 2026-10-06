<x-docs.page
    lead="A component's public properties are its state. The server renders them, the browser keeps them, and your methods change them, wherever those methods run."
>
    <p>
        Every public property of a component is part of its state. The server renders the first page with it, and
        the browser then keeps it. Your methods change it, most of them in the browser and the
        <code>#[Server]</code> ones on the server. There is nothing to wire up. You declare a property and use it in
        the view.
    </p>

    <x-docs.example component="counter" title="A counter" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        The counter above has two properties. <code>increment()</code> changes <code>$count</code> in the browser,
        without a request. Its <code>#[Validate]</code> rule is checked on the server before <code>save()</code>
        runs, so a count sent from outside the page can't be negative or huge. <code>$savedAt</code> is marked
        <code>#[Locked]</code>, so the browser shows it but only <code>save()</code> on the server can set it. Open
        <strong>Compiled</strong> to see what the browser runs.
    </p>

    <x-docs.pair class="app/Fusion/Components/Counter.php" view="resources/views/fusion/components/counter.blade.php" component="counter" />

    <x-docs.callout type="note" title="This demo saves to the session">
        <p>So that the example works for every visitor, without an account or a database, <code>save()</code> keeps the count in your session. Your application would save it to the database in the same way. The call to the server, the validation and the new state that comes back all stay the same.</p>
    </x-docs.callout>

    <h2 id="types">Property types</h2>
    <p>
        A property can hold <code>null</code>, a <code>bool</code>, an <code>int</code>, a <code>float</code>, a
        <code>string</code>, an <code>array</code>, a backed enum, an Eloquent model or collection, or an upload. A
        typed property always keeps its type. If the browser sends a value of another type, the server refuses it
        rather than converting it.
    </p>

    @php
        $types = [
            ['bool, int, float, string', 'The browser can only set it to a value of the same type (an int is accepted for a float).'],
            ['array', 'A value, as in PHP: a copy never changes the property. Keys and their order survive the round trip.'],
            ['Backed enum', 'The browser holds the case as its value, and can only send the value of one of its cases. The enum must be marked #[Browser].'],
            ['Model, Collection', 'Sent to the browser as their visible attributes. Read again from the database on every #[Server] call, never taken from the browser.'],
            ['Upload, #[Uploads] array', 'Files from a file input, stored by a #[Server] method. See Uploads.'],
        ];
    @endphp
    <x-docs.api-table :columns="['Type', 'How it behaves']" :rows="$types" />

    <h3 id="models">Model properties</h3>
    <p>Fusion reads a model property again from the database on each server call:</p>

    <x-docs.code src="model-property.php" />

    <ul>
        <li>A collection keeps its order, keeps each model as its own class, and leaves out rows that have been deleted since.</li>
        <li>If a single model's row has been deleted, a nullable property (<code>public ?Post $post</code>) becomes <code>null</code>, so the component can tell and the view can show it. A property that isn't nullable answers with a 404.</li>
    </ul>

    <x-docs.callout type="note" title="Arrays are values">
        <p>As in PHP, <code>$copy = $this-&gt;items</code> makes a copy, so changing <code>$copy</code> never changes the property. The browser follows this rule too.</p>
    </x-docs.callout>

    <p>
        To read and change arrays and models in your views and methods, and to choose between them, see
        <a href="/docs/arrays-and-models">Arrays and models</a>.
    </p>

    <h2 id="attributes">Property attributes</h2>
    <p>You can mark a property with these attributes to change how it behaves:</p>

    @php
        $propertyAttributes = [
            ['#[Locked]', 'The browser can read it, but only the server can change it.'],
            ['#[Url]', 'Keeps the property in the query string (with as, history, keep and except). Fusion reads it before mount() and keeps it in sync with the property.'],
            ['#[Remember]', 'Keeps the value in the browser’s history entry, so back, forward and a reload bring it back, such as a half-filled form.'],
            ['#[Modelable]', 'Lets a parent bind this property with fusion:model. Only one property can have it.'],
            ['#[Validate]', 'Rules the server checks whenever the browser changes the property.'],
        ];
    @endphp
    <x-docs.api-table :columns="['Attribute', 'What it does']" :rows="$propertyAttributes" />

    <h3 id="locked">Locking a property</h3>
    <p>
        The browser can read a property marked <code>#[Locked]</code>, but only the server can change it, in
        <code>mount()</code> or in a <code>#[Server]</code> method. Because the state is signed, the server refuses
        a changed value.
    </p>

    <x-docs.code src="locked.php" file="app/Fusion/Components/Wallet.php" highlight="5,6" />

    <x-docs.callout type="warning" title="Locked doesn't mean current">
        <p>Signing stops the browser from changing <code>$balance</code>. It doesn't stop the same visitor from sending an older state from their own session. So read anything that must be current, such as a balance or a permission, from the database in the <code>#[Server]</code> method.</p>
    </x-docs.callout>

    <h3 id="url">Keeping a property in the query string</h3>
    <p><code>#[Url]</code> keeps a property in the query string, so a search or a page number survives a reload and can be shared:</p>

    <x-docs.code src="url.php" />

    <h3 id="validation">Validating properties</h3>
    <p>
        The browser can set any property that isn't <code>#[Locked]</code> to <strong>any value of its type</strong>.
        Anyone can send a request without using the page, so <code>$quantity</code> could arrive as
        <code>-500</code>. Before a <code>#[Server]</code> method runs, the server checks the type of what changed,
        and its <code>#[Validate]</code> rules. If a rule fails, the method doesn't run, and the messages appear in
        <code>$errors</code>.
    </p>

    <x-docs.code src="validate.php" runs="server" highlight="1" />

    <x-docs.callout type="tip" title="Validate everything a server method relies on">
        <p>Put a rule on every property that a <code>#[Server]</code> method uses, or validate in the method itself. Calling <code>$this-&gt;validate()</code> without rules checks every property's <code>#[Validate]</code> rules, which is useful before saving a form.</p>
    </x-docs.callout>

    <x-docs.callout type="danger" title="Never put secrets in public properties">
        <p>Every public property is sent to the browser, including <code>#[Locked]</code> ones, and a model property carries its visible attributes. Keep secrets in protected or private properties, or load them in the method that needs them.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/methods" title="Methods" icon="browser" runs="browser">Write code that runs in the browser, with no request and no waiting.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Use the database, mail and anything else that needs the server.</x-docs.card>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs with fusion:model, and validate with #[Validate] and $errors.</x-docs.card>
        <x-docs.card href="/docs/uploads" title="Uploads" icon="bolt">Preview files from a file input at once, and store them on the server.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="A Fusion form is a set of properties bound to inputs with fusion:model, a #[Server] method that saves them, and rules that the server checks before that method runs. The browser gives instant hints, and the server has the final say."
>
    <p>
        As you type, the component's properties change in the browser, so hints and computed values update on
        every keystroke without a request. Submitting the form calls a <code>#[Server]</code> method. The server
        checks the <code>#[Validate]</code> rules first. If they pass, it runs the method. If they fail, it sends
        the messages back as <code>$errors</code>.
    </p>

    <x-docs.example component="signup-form" title="A form" source="#the-component" />

    <p>
        Submit the form empty, and the messages come from the server. Type an email, and the hint under it is
        worked out in the browser as you type. Fill in the form and submit it, and the server saves it and clears
        the fields.
    </p>

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Fusion/Components/SignupForm.php" view="resources/views/fusion/components/signup-form.blade.php" component="signup-form" />

    <x-docs.callout type="note" title="Saved in the session, for this demo">
        <p>So that the example works for every visitor, <code>submit()</code> keeps the email in your session. Your app would create the account in the database the same way.</p>
    </x-docs.callout>

    <h2 id="binding">Binding inputs</h2>
    <p>
        <code>fusion:model</code> keeps an input and a property in sync, in both directions. It works with text
        fields, text areas, radio buttons, checkboxes and selects. Use a dotted path to bind a key of an array
        property.
    </p>

    <x-docs.code src="form-model.blade.php" lang="blade" />

    <p>Add a modifier to change when and how the property is set:</p>

    @php
        $modifiers = [
            ['`.blur`', 'Sets the property when the field loses focus, instead of on every keystroke'],
            ['`.change`, `.lazy`', 'Sets it when the field\'s value is committed (the `change` event), like `.blur`'],
            ['`.live`', 'Sets it on every keystroke. That is what `fusion:model` does already, so it changes nothing; it is accepted for code written for Livewire'],
            ['`.debounce.300ms`', 'Sets it once typing pauses'],
            ['`.trim`', 'Removes spaces around the text'],
            ['`.number`', 'Sets it as a number, or `null` when the field is empty'],
            ['`.boolean`', 'Sets it as `true` or `false`, from `"true"` or `"1"`'],
        ];
    @endphp
    <x-docs.table :columns="['Modifier', 'Does']" :rows="$modifiers" />

    <h2 id="validation">Validating input</h2>
    <p>
        Add rules to a property with <code>#[Validate]</code>, or pass them to <code>$this-&gt;validate([...])</code>
        in a method. On every <code>#[Server]</code> call, the server checks the rules of the properties the browser
        changed, before the method runs. If a rule fails, the method doesn't run. Calling
        <code>$this-&gt;validate()</code> without rules checks every property's rules, as <code>submit()</code> does
        before it saves.
    </p>

    <x-docs.code src="form-validate.php" runs="server" highlight="1,4,10,11" />

    <x-docs.callout type="warning" title="Hints in the browser, rules on the server">
        <p>Anything the browser checks is only a convenience, because anyone can send a request without your page. The rules that protect what a method saves belong on the server, on the property or in the method.</p>
    </x-docs.callout>

    <h2 id="errors">Showing errors</h2>
    <p>
        Error messages arrive with the component's state, as <code>$errors</code>. <code>@@error</code> works as it
        does in any Blade view. <code>$errors</code> has the <code>has()</code>, <code>first()</code>,
        <code>get()</code>, <code>all()</code>, <code>any()</code> and <code>count()</code> methods, in the browser
        too. Use <code>as:</code> on <code>#[Validate]</code> to name the field in its messages.
    </p>

    <x-docs.code src="form-errors.blade.php" lang="blade" />

    <h2 id="loading">Showing that the form is saving</h2>
    <p>
        <code>fusion:loading</code> shows an element while a <code>#[Server]</code> call runs. Add
        <code>.attr="disabled"</code> to disable a button, or <code>.remove</code> to hide its label (see
        <a fusion:navigate href="/docs/server-methods#loading">Server methods</a>). Add <code>.delay</code> so a
        quick save shows nothing.
    </p>

    <h2 id="unsaved">Showing unsaved changes</h2>
    <p>
        Your browser methods and <code>fusion:model</code> change the state at once, without a request. So the
        page can hold changes that the server hasn't seen yet. <code>fusion:dirty</code> shows an element while it
        does, and hides it again once a <code>#[Server]</code> call has taken the changes:
    </p>

    <x-docs.code src="form-dirty.blade.php" lang="blade" />

    <ul>
        <li><strong>It compares values.</strong> Type a field back to what the server has, and it is no longer a change.</li>
        <li><strong>Narrow it with <code>fusion:target</code>.</strong> Name properties or paths: <code>fusion:target="title,form.email"</code>. Without it, any change counts.</li>
        <li><strong>The same forms as <code>fusion:loading</code>.</strong> <code>.remove</code> hides the element instead, <code>.class="..."</code> and <code>.class.remove="..."</code> change classes, <code>.attr="..."</code> sets an attribute.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/uploads" title="Uploads" icon="bolt">Accept files from a file input, preview them at once, and check them on the server.</x-docs.card>
        <x-docs.card href="/docs/properties#validation" title="What the browser can change" icon="server" runs="server">Learn how types, #[Locked] and #[Validate] protect your properties.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

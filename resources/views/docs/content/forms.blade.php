<x-docs.page
    lead="A Nitro form is a set of properties bound to inputs with nitro:model, a #[Server] method that saves them, and rules that the server checks before that method runs. The browser gives instant hints, and the server has the final say."
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
    <x-docs.pair class="app/Nitro/Components/SignupForm.php" view="resources/views/nitro/components/signup-form.blade.php" component="signup-form" />

    <x-docs.callout type="note" title="Saved in the session, for this demo">
        <p>So that the example works for every visitor, <code>submit()</code> keeps the email in your session. Your app would create the account in the database the same way.</p>
    </x-docs.callout>

    <h2 id="binding">Binding inputs</h2>
    <p>
        <code>nitro:model</code> keeps an input and a property in sync, in both directions. It works with text
        fields, text areas, radio buttons, checkboxes and selects. Use a dotted path to bind a key of an array
        property.
    </p>

    <x-docs.code src="form-model.blade.php" lang="blade" />

    <p>Add a modifier to change when and how the property is set:</p>

    @php
        $modifiers = [
            ['`.blur`', 'Sets the property when the field loses focus, instead of on every keystroke'],
            ['`.change`, `.lazy`', 'Sets it when the field\'s value is committed (the `change` event), like `.blur`'],
            ['`.live`', 'Sets it on every keystroke. That is what `nitro:model` does already, so it changes nothing; it is accepted for code written for Livewire'],
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

    <h3 id="validate-only">Checking part of the form</h3>
    <p>
        <code>$this-&gt;validateOnly()</code> checks the <code>#[Validate]</code> rules of the properties it names, and no
        others. A wizard's Next checks its own step; a draft saves with a title while the rest is still empty. A key under
        an array property names its rules and those below it:
    </p>

    <x-docs.code src="form-validate-only.php" runs="server" />

    <h3 id="validate-on-blur">Checking a field as it is left</h3>
    <p>
        Add <code>onBlur: true</code> to a property's <code>#[Validate]</code>, and the server checks its rules when the
        visitor leaves a field bound to it. Every Laravel rule works, <code>unique</code> too, and rules that read
        another field, such as <code>confirmed</code>, see what that field holds now:
    </p>

    <x-docs.code src="form-validate-blur.php" runs="server" highlight="1,4" />

    <p>The view shows the message as it would after a submit:</p>

    <x-docs.code src="form-validate-blur.blade.php" lang="blade" />

    <ul>
        <li><strong>Only that field's message changes.</strong> The other fields' messages stay, and a field still being typed is not checked until it is left.</li>
        <li><strong>Nothing else happens.</strong> No hook or method runs, the form keeps what the visitor typed, and the change still counts as unsaved for <code>nitro:dirty</code>.</li>
        <li><strong>Only when it changed.</strong> Leaving a field without changing it, or with the value it was last checked with, asks nothing.</li>
        <li><strong>The rules run again on submit.</strong> A check helps the visitor; <code>$this-&gt;validate()</code> in the method is what protects what it saves.</li>
        <li><strong>Lists.</strong> A field of a row, such as <code>lines.0.qty</code>, is checked with its list's rules (<code>lines.*.qty</code>).</li>
    </ul>

    <p>
        A check shows no progress bar and no <code>nitro:loading</code> without a target. With
        <code>nitro:target="email"</code>, as above, an element shows while the email is checked. In a Vue, React, Solid or
        Svelte view, call <code>validate('email')</code> on the field's own blur: it returns a promise of the field's messages.
    </p>

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
        <code>nitro:loading</code> shows an element while a <code>#[Server]</code> call runs. Add
        <code>.attr="disabled"</code> to disable a button, or <code>.remove</code> to hide its label (see
        <a nitro:navigate href="/docs/server-methods#loading">Server methods</a>). Add <code>.delay</code> so a
        quick save shows nothing.
    </p>

    <h2 id="unsaved">Showing unsaved changes</h2>
    <p>
        Your browser methods and <code>nitro:model</code> change the state at once, without a request. So the
        page can hold changes that the server hasn't seen yet. <code>nitro:dirty</code> shows an element while it
        does, and hides it again once a <code>#[Server]</code> call has taken the changes:
    </p>

    <x-docs.code src="form-dirty.blade.php" lang="blade" />

    <ul>
        <li><strong>It compares values.</strong> Type a field back to what the server has, and it is no longer a change.</li>
        <li><strong>Narrow it with <code>nitro:target</code>.</strong> Name properties or paths: <code>nitro:target="title,form.email"</code>. Without it, any change counts.</li>
        <li><strong>The same forms as <code>nitro:loading</code>.</strong> <code>.remove</code> hides the element instead, <code>.class="..."</code> and <code>.class.remove="..."</code> change classes, <code>.attr="..."</code> sets an attribute.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/uploads" title="Uploads" icon="bolt">Accept files from a file input, preview them at once, and check them on the server.</x-docs.card>
        <x-docs.card href="/docs/properties#validation" title="What the browser can change" icon="server" runs="server">Learn how types, #[Locked] and #[Validate] protect your properties.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

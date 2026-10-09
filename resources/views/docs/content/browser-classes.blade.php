<x-docs.page
    lead="Browser classes let your components share code, such as formatting money or a pricing rule. Mark a class or an enum with #[Browser], and your browser methods and views can use it just as your PHP does."
>
    <p>
        Code that several components need doesn't have to be copied into each of them, or moved into a
        <code>#[Server]</code> method that costs a request. Put it in a class of its own, mark the class with
        <code>#[Browser]</code>, and Nitro compiles it for the browser too. On the server, it stays an ordinary PHP
        class.
    </p>

    <x-docs.example component="order-tracker" title="An order, its status and its prices" source="#the-component" />

    <p>
        The order's status is a <code>#[Browser]</code> enum, and its prices are formatted by a
        <code>#[Browser]</code> class. Pick a status or click <strong>Next step</strong>: the label and the next step
        change in the browser, with no request. <strong>Save on the server</strong> sends the status to a
        <code>#[Server]</code> method. Reload the page, and the status you saved is still there.
    </p>

    <h2 id="classes">Creating a browser class</h2>
    <p>
        Add the <code>#[Browser]</code> attribute to a class. Its static methods and its constants are then available
        in the browser:
    </p>

    <x-docs.code src="app/Support/Money.php" file="app/Support/Money.php" highlight="7" />

    <p>You can call it from any browser method, as you would in PHP:</p>

    <x-docs.code src="browser-class-call.php" runs="browser" />

    <ul>
        <li><strong>The same rules as browser methods.</strong> A browser class can't use the database, the clock or anything else that needs the server. If one of its methods does, the build fails and tells you the file and line.</li>
        <li><strong>Only what you use is compiled.</strong> Nitro compiles the methods your browser code calls, and the methods they call in turn. A method that nothing calls in the browser is never compiled, so it can use anything.</li>
        <li><strong>Constants become their values.</strong> <code>Money::CURRENCY</code> is compiled as <code>'£'</code>.</li>
        <li><strong>Private methods and constants</strong> work inside their own class, with <code>self::</code>.</li>
        <li><strong>Static methods only.</strong> You can't create instances (<code>new Money(...)</code>) or use static properties in the browser.</li>
    </ul>

    <h2 id="use">Using a class in a view</h2>
    <p>
        A view has no <code>use</code> statements, so import the classes it needs with Blade's <code>@@use</code>
        directive. Nitro reads <code>@@use</code> exactly as Blade does:
    </p>

    <x-docs.code src="browser-use.blade.php" lang="blade" />

    <p>
        An import applies to the whole view, as a PHP <code>use</code> statement does, and an included view can
        import its own. Without <code>@@use</code>, write the class's full name, such as
        <code>\App\Support\Money::format($total)</code>.
    </p>

    <h2 id="enums">Using enums</h2>
    <p>
        An enum marked with <code>#[Browser]</code> works in the browser just as it does in PHP. You can use its
        cases, <code>cases()</code>, <code>from()</code>, <code>tryFrom()</code>, its methods and its static methods:
    </p>

    <x-docs.code src="app/Enums/OrderStatus.php" file="app/Enums/OrderStatus.php" highlight="7" />
    <x-docs.code src="browser-enum-calls.php" runs="browser" />

    <p>
        Each case is a single object in the browser, so <code>===</code>, <code>match</code> and
        <code>in_array(..., true)</code> compare cases the way PHP does, and <code>-&gt;name</code> and
        <code>-&gt;value</code> work as usual.
    </p>

    <h3 id="enum-properties">Using an enum as a property</h3>
    <p>A component property can hold a backed enum:</p>

    <x-docs.code src="browser-enum-property.php" runs="browser" highlight="3" />
    <x-docs.code src="browser-enum-view.blade.php" lang="blade" />

    <ul>
        <li><strong><code>nitro:model</code> works as usual.</strong> A <code>&lt;select&gt;</code> sets the property from the selected option's value, and your code reads it as a case.</li>
        <li><strong>The server receives a case.</strong> The property travels as its value, and the server turns it back into the case before your methods run.</li>
        <li><strong>The browser can only send real cases.</strong> A value that isn't one of the enum's cases, or isn't of its backing type, is refused with a 403.</li>
        <li><strong>The enum must be backed and marked <code>#[Browser]</code>.</strong> If it isn't, the build tells you.</li>
    </ul>

    <x-docs.callout type="note" title="Methods on a value">
        <p>When you call a method on a value, such as <code>$case-&gt;label()</code>, Nitro compiles that method for the <code>#[Browser]</code> enums your code uses. In the browser, only an enum case has methods. Data from the server arrives as arrays, so calling a method on it fails the build.</p>
    </x-docs.callout>

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Nitro/Components/OrderTracker.php" view="resources/views/nitro/components/order-tracker.blade.php" component="order-tracker" />

    <x-docs.callout type="note" title="Saved in the session, for this demo">
        <p>So the example works for every visitor without an account or a database, <code>save()</code> keeps the status in your session. Your app would save it to the database in the same way.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/methods" title="Methods" icon="browser" runs="browser">Write the browser methods that call your classes.</x-docs.card>
        <x-docs.card href="/docs/limitations" title="Limitations" icon="book">See what behaves differently in the browser.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

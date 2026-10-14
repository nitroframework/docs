<x-docs.page
    lead="Nitro runs your methods and views in the browser, and that has a few consequences. Server work stays on the server, numbers and regular expressions follow the browser's rules, a few PHP functions aren't available, and a few things Blade allows can't be used in a component's view. None of these ever gives a different result silently."
>
    <h2 id="server-work">Keeping server work in #[Server] methods</h2>
    <p>
        Queries, services, <code>Auth</code>, <code>Cache</code>, files, mail and the clock (<code>now()</code>,
        <code>date()</code>) all belong to the server. If a browser method uses them, the build fails and tells you
        the file and line.
    </p>
    <x-docs.code src="limitations-server.php" highlight="4,11" />

    <h2 id="mount">Creating components with mount()</h2>
    <p>
        Only the server can create a component that has a <code>mount()</code> method. It does so on the first
        request, on a visit, or during a <code>#[Server]</code> call of the component whose view places it. A change
        made only in the browser, such as <code>$set</code> or a browser method, can't place a new one. So a
        <code>&lt;nitro:dynamic-component&gt;</code> that switches to such a component needs one of those first.
    </p>

    <h2 id="values">Numbers, strings and patterns</h2>
    <ul>
        <li><strong>Numbers follow JavaScript.</strong> Integers are exact up to 2<sup>53</sup>, so <code>PHP_INT_MAX</code> is 2<sup>53</sup>-1 in the browser. A whole float arrives as an int. Functions such as <code>tanh</code> may differ in the last digit, just as they do between PHP builds.</li>
        <li><strong>Strings are UTF-8.</strong> Byte functions such as <code>strlen</code> and <code>substr</code> count bytes, as PHP does. A result that isn't valid UTF-8 appears as U+FFFD.</li>
        <li><strong>Regular expressions follow PCRE</strong>, translated to JavaScript. Features without an exact equivalent fail with a message: recursion, conditional groups, <code>\K</code>, backtracking verbs, callouts, <code>(?|</code>, inline modifiers inside the pattern, and duplicate group names. Without the <code>/u</code> flag, patterns match bytes.</li>
        <li><strong>Unicode follows the browser.</strong> Case mapping and character classes use the browser's Unicode version, which can be older than PHP's.</li>
    </ul>

    <h2 id="not-available">What isn't available in the browser</h2>
    <ul>
        <li>The <code>$count</code> argument of <code>preg_replace()</code>, and the percentage of <code>similar_text()</code></li>
        <li><code>strip_tags()</code> with allowed tags</li>
        <li><code>mb_convert_case()</code> modes other than upper, lower and title</li>
        <li><code>Str::</code> methods that haven't been ported (such as <code>plural</code>, <code>uuid</code> and <code>of</code>), and <code>Str::slug</code> and <code>Str::ascii</code> in languages other than <code>en</code></li>
        <li><code>htmlentities()</code> and <code>html_entity_decode()</code> with <code>ENT_HTML5</code>, <code>ENT_XHTML</code> or <code>ENT_XML1</code></li>
    </ul>
    <p>Using one of these fails the build or fails with a message. They never give a different result from PHP. Call them from a <code>#[Server]</code> method instead.</p>

    <h2 id="blade">Blade in a component's view</h2>
    <p>
        A component's view is compiled once and rendered by the server and the browser by the same rules, and
        both are tested against Laravel's Blade. Your layouts, mail and other plain Blade views are untouched:
        Laravel renders them as always. In a component's view, these fail the build with the file, the line and
        what to write instead:
    </p>
    @php
        $refused = [
            ['`@php`, custom directives, `@aware`', 'Work out values in the component (a property, a `#[Computed]` method)'],
            ['Class-based Blade components (`app/View/Components`)', 'Use an anonymous component (`resources/views/components`)'],
            ['`<x-dynamic-component>`, `<x-slot :name>` with a computed name', 'Use `<nitro:dynamic-component :is>`; name slots with a string'],
            ['A loop\'s variable read after the `@if` (or outer loop) the loop is in has ended', 'Read it inside that block. Right after the loop itself it works, as in PHP'],
            ['An element opened in `@if` or `@foreach` and closed outside it', 'Open and close the element inside the block'],
            ['A block element inside a `<p>` (`<p><div>`), also through a component', 'Close the `<p>` first, or use a `<div>`'],
            ['A row inside an open row, a cell inside an open cell', 'Close the row or cell first'],
            ['Rows a loop renders directly in a `<table>`', 'Wrap them in `<tbody>`. Rows written directly in the table are fine: the `<tbody>` is added for you, as browsers add it'],
            ['Markup inside an `<option>` (`<option><b>x</b></option>`)', 'Put only text in it: browsers disagree about markup there'],
            ['A Blade component reading data the views share (`View::share()`) without being given it', 'Pass it as an attribute'],
        ];
    @endphp
    <x-docs.table :columns="['Fails the build', 'Write instead']" :rows="$refused" />
    <p>And a few things render, but not quite as Laravel would:</p>
    <ul>
        <li><strong>Data shared during a request</strong>, by a view composer or a middleware, doesn't reach an
            <code>@@include</code>d view or a Blade component inside a component's view. Pass it as data or as an
            attribute.</li>
        <li><strong><code>@@includeFirst</code></strong> picks its view when the view is compiled, not on every render.</li>
        <li><strong>The server's HTML</strong> is written from the compiled view. The page the browser builds from it is
            exactly the one Blade's HTML gives, but the bytes can differ (attributes in double quotes, for example). In
            tests, check what a component shows (<code>assertSee</code>), not Blade's exact HTML.</li>
    </ul>

    <h2 id="portals">Teleporting to portals</h2>
    <p>
        <code>@@teleport</code> targets a named <code>@@portal</code> instead of a CSS selector, so the server can
        render it too. You can define each <code>@@portal</code> only once per page.
    </p>

    <x-docs.callout type="tip" title="Checked in both places">
        <p>Nitro's own tests run thousands of random methods and views in PHP and, compiled, in the browser, and treat any difference as a bug. What this page lists is what remains different by design.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Put the work that needs the server in #[Server] methods.</x-docs.card>
        <x-docs.card href="/docs/how-it-works" title="How Nitro works" icon="book">Learn how the compiler, the runtime and the endpoint fit together.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

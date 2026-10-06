<x-docs.page
    lead="Fusion runs your methods in the browser, and that has a few consequences. Server work stays on the server, numbers and regular expressions follow the browser's rules, and a few PHP functions aren't available. None of these ever gives a different result silently."
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
        <code>&lt;fusion:dynamic-component&gt;</code> that switches to such a component needs one of those first.
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

    <h2 id="portals">Teleporting to portals</h2>
    <p>
        <code>@@teleport</code> targets a named <code>@@portal</code> instead of a CSS selector, so the server can
        render it too. You can define each <code>@@portal</code> only once per page.
    </p>

    <x-docs.callout type="tip" title="Checked in both places">
        <p>Fusion's own tests run thousands of random methods and views in PHP and, compiled, in the browser, and treat any difference as a bug. What this page lists is what remains different by design.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Put the work that needs the server in #[Server] methods.</x-docs.card>
        <x-docs.card href="/docs/how-it-works" title="How Fusion works" icon="book">Learn how the compiler, the runtime and the endpoint fit together.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

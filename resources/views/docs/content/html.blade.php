<x-docs.page
    lead="Some HTML is best made on the server: Markdown rendered, code highlighted, a diff, an SVG chart. Mark the method #[Html], and Nitro makes it there and hands it to the view, without making the component's state any heavier."
>
    <p>
        A component's properties are its state. They go to the browser, signed, and come back with every
        <code>#[Server]</code> call, so the server can trust them. That suits a title or a quantity. It doesn't suit
        a rendered article or a 5,000-line highlighted file: as a property, that HTML would travel to the server
        and back with every click on the page.
    </p>

    <p>
        An <code>#[Html]</code> method runs on the server only. Its HTML goes to the browser beside the state, not in
        it. It is never signed, and never sent back.
    </p>

    <h2 id="writing-one">Writing one</h2>
    <p>Mark a public method that takes nothing and returns a string:</p>

    <x-docs.code src="html-article.php" file="app/Nitro/Pages/Posts/Show.php" runs="both" />

    <p>The view reads it like a property, and places it unescaped, since it is HTML already:</p>

    <x-docs.code src="html-article.blade.php" lang="blade" file="resources/views/nitro/pages/posts/show.blade.php" />

    <p>A <a nitro:navigate href="/docs/javascript-views">JavaScript view</a> reads it by the method's name, as each framework places HTML:</p>

    @php
        $frameworks = [
            ['Vue', '`<div class="prose" v-html="body" />`'],
            ['React', '`<div className="prose" dangerouslySetInnerHTML={{ __html: body }} />`'],
            ['Solid', '`<div class="prose" innerHTML={body} />`'],
            ['Svelte', '`<div class="prose">{@html body}</div>`'],
        ];
    @endphp
    <x-docs.table :columns="['View', 'Placing body']" :rows="$frameworks" />

    <h2 id="when-it-runs">When it runs</h2>
    <p>
        Whenever the server sends the component's state to the browser: on the first page, on a
        <a nitro:navigate href="/docs/navigation">visit</a>, and after each <code>#[Server]</code> call. The view
        always shows the latest HTML the server made.
    </p>

    <x-docs.callout type="note" title="Changed in the browser, made again by the server">
        <p>
            The browser can't run an <code>#[Html]</code> method. When a browser method changes what the HTML is made
            from, such as <code>$markdown</code> while someone types, the HTML shows the old text until the next
            <code>#[Server]</code> call. A preview as you type belongs in the browser: keep <code>#[Html]</code> for the
            HTML the server must make.
        </p>
    </x-docs.callout>

    <h2 id="what-travels">What travels</h2>
    <p>
        The browser keeps the HTML apart from the state, with a short fingerprint of it. A call sends back the
        fingerprint alone, and the server leaves out of its answer any HTML whose fingerprint still matches. So
        a click on a page showing a long file sends a few bytes, and gets the file again only if it changed.
    </p>

    @php
        $travels = [
            ['As a property', 'With the page, inside the signed state', 'All of it, with every call', 'With every call'],
            ['As `#[Html]`', 'With the page, beside the state', 'Its fingerprint (a few bytes)', 'Only when it changed'],
        ];
    @endphp
    <x-docs.table :columns="['A long file', 'To the browser', 'Back to the server', 'Again after a call']" :rows="$travels" />

    <h2 id="keeping-it-fast">Keeping it fast</h2>
    <p>
        The method runs each time the server answers. A slow one (highlighting, rendering a large document) should
        keep its result, keyed by what it is made from:
    </p>

    <x-docs.code src="html-cache.php" />

    <h2 id="safe-html">Safe HTML</h2>
    <p>
        The view places the HTML as it is, so make it safe where you make it: escape what you put in it, and render
        Markdown with raw HTML escaped (<code>'html_input' => 'escape'</code>), as above. The HTML a browser could
        send back is never read: the server makes it again each time.
    </p>

    <h2 id="rules">Rules</h2>
    <p>The build stops, naming the file and line, when an <code>#[Html]</code> method:</p>
    <ul>
        <li>doesn't declare <code>: string</code>, or takes parameters;</li>
        <li>isn't public;</li>
        <li>is also <code>#[Server]</code> or <code>#[Computed]</code> (it runs on the server already, and is read as a property);</li>
        <li>is on a <a nitro:navigate href="/docs/sharing-state">store</a>, which has no view: put it on the component that shows it.</li>
    </ul>
</x-docs.page>

<x-docs.page
    lead="fusion:navigate moves between pages without a full reload. The first page load is the server's HTML. After that, the browser asks only for the next page's data and renders it in place, keeping the layout."
>
    <p>
        To make a link navigate without a reload, add <code>fusion:navigate</code> to it. Laravel handles the
        visit as usual, including middleware, route bindings and redirects. The page runs <code>mount()</code>
        and answers with its state and title. The browser then renders the new page in place of the current one,
        and the layout and its components stay where they are.
    </p>

    <x-docs.example component="visit" title="Visiting from a link or from code" source="#links" />

    <h2 id="links">Adding links</h2>

    <x-docs.code src="navigate-link.blade.php" lang="blade" highlight="1" />

    @php
        $linkOptions = [
            ['`fusion:navigate`', 'Visits the link\'s page without a reload'],
            ['`.keypress`', 'Starts the visit when the mouse button goes down, instead of on the click. Touch and keyboard still use the click'],
            ['`.preserve-scroll`', 'Keeps the scroll position. Without it, a visit scrolls to the top, or to the URL\'s `#fragment`'],
            ['`fusion:current="class"`', 'Adds the class while the link points at the current page, and sets `aria-current="page"`. Add `.exact` to match the same path only'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'Does']" :rows="$linkOptions" />

    <p>
        You can also visit a page from code. Call <code>$visit(url)</code> in a handler, or
        <code>$this-&gt;redirect($url, navigate: true)</code> in a method. The back and forward buttons return to
        where you left each page.
    </p>

    <x-docs.callout type="note" title="Links are for other pages">
        <p>To filter or sort what a page shows, change a property with <code>$set()</code> or <code>fusion:model</code> and let the view render again. That needs no visit, and in the browser it needs no request.</p>
    </x-docs.callout>

    <h2 id="any-page">Visiting any page</h2>
    <p>
        A link can lead anywhere in your application. When the target is a Fusion page in the same layout, the
        browser renders it from its data. Anything else is fetched as HTML and replaces the document, still
        without a reload. That includes a plain Blade view, a page in another layout, or a view returned by a
        controller. When this happens:
    </p>
    <ul>
        <li>New stylesheets load before the page shows, so it never appears unstyled.</li>
        <li>Its new scripts run, and its components and islands start.</li>
        <li>An error page or a download loads normally.</li>
    </ul>
    <p>
        Every visit sends the version of your build. If a new build has been deployed since the page loaded, the
        server answers with a <code>409</code>, and the browser loads the page in full with the new code.
    </p>

    <h2 id="modes">Choosing how a visit shows a page</h2>
    <p>
        Each page chooses what a visit does with <code>#[Navigate]</code>. First, ask whether the page needs the
        server at all. If it doesn't, it can be a <strong>client</strong> page. If it does, decide whether it
        should appear after its data arrives (<strong>data</strong>, the default) or before
        (<strong>markup</strong>).
    </p>

    @php
        $modes = [
            ['`data` (default)', 'Asks the server for the page\'s data, then renders the complete page. This takes one round trip, and nothing shows half-filled', 'Pages that mean nothing without their data, and pages behind `auth` or `can`'],
            ['`markup`', 'Renders the page at once with its properties\' defaults, then fills it in when the data arrives', 'Dashboards, lists and forms with placeholders'],
            ['`client`', 'Renders the page at once and doesn\'t ask the server at all', 'Help, about pages, legal text, docs'],
        ];
    @endphp
    <x-docs.table :columns="['Mode', 'The browser', 'Suits']" :rows="$modes" />

    <p>The first page load is always the server's HTML. The mode only decides what later visits do.</p>

    <h3 id="markup-first">Showing the markup first</h3>
    <p>Set the default in <code>config/fusion.php</code>, and choose for a single page with <code>#[Navigate]</code>:</p>

    <x-docs.code src="navigate-config.php" />
    <x-docs.code src="navigate-markup.php" highlight="3" />

    <p>
        During a markup-first visit, every property counts as deferred until the data arrives. Use
        <code>@@deferred</code> and <code>@@placeholder</code> to choose what to show in the meantime:
    </p>

    <x-docs.code src="navigate-markup.blade.php" lang="blade" />

    <ul>
        <li>The view must render with the properties' defaults. Guard data that isn't there yet with <code>@@deferred</code> or <code>??</code>. For example, don't read <code>$student['name']</code> from an empty array.</li>
        <li>Anything the visitor types or toggles before the data arrives is kept. A <code>#[Server]</code> call made in the meantime waits for the data.</li>
        <li>Components created by the server (those with <code>mount()</code>) appear when the data arrives, and the title is set at that point.</li>
        <li>A page in another layout, a redirect or an error is handled the same way as in a data-first visit.</li>
    </ul>

    <h3 id="client-pages">Client pages</h3>
    <p>A page that needs nothing from the server can skip the server entirely on a visit:</p>

    <x-docs.code src="navigate-client.php" highlight="2" />

    <p>
        The browser renders a client page from its compiled view as soon as the link is clicked, without a
        request. Its title and head tags are worked out when you build the app. Its state and browser methods work
        as they do on any page, and the back and forward buttons render it again without a request. A reload or a
        first visit still gets the server's HTML.
    </p>
    <p>A client page can't use anything that only the server can do. The build refuses a client page that has:</p>
    <ul>
        <li><code>mount()</code>, <code>#[Server]</code> methods or <code>#[Url]</code> properties.</li>
        <li>Route parameters, or middleware beyond the <code>web</code> group (such as <code>auth</code>, <code>can</code> or <code>verified</code>), because only the server can check them.</li>
    </ul>
    <p>For those pages, use <code>#[Navigate('markup')]</code> instead. It also renders at once, and then asks the server for the rest.</p>

    <h2 id="progress-bar">Showing a progress bar</h2>
    <p>
        During a visit, a bar runs along the top of the window, as it does on these docs. To configure it, publish
        its configuration with <code>php artisan vendor:publish --tag=nprogress-config</code>:
    </p>

    @php
        $progress = [
            ['`show`', 'Shows the bar'],
            ['`server_calls`', 'Shows it during `#[Server]` calls too'],
            ['`color`, `height`, `position`, `z_index`', 'Its look'],
            ['`glow`, `glow_width`, `spinner`, `spinner_size`', 'The glow at its tip, and a spinner'],
            ['`delay`', 'How long to wait before it appears, in milliseconds'],
            ['`minimum_duration`', 'How long it runs at least once shown, in milliseconds. A fast visit is then seen to complete rather than flash'],
            ['`minimum`, `maximum`, `trickle`, `trickle_speed`, `speed`, `easing`, `fade_speed`', 'Its motion'],
        ];
    @endphp
    <x-docs.table :columns="['Option', '']" :rows="$progress" />

    <p>The bar's markup is <code>#nprogress .bar</code>, so existing NProgress styles apply to it.</p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/head" title="The page's head" icon="book">Set titles, descriptions and link previews on every visit.</x-docs.card>
        <x-docs.card href="/docs/page-data" title="Page data" icon="server" runs="server">Defer, reload and merge properties, and share data with every page.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

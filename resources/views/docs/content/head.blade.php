<x-docs.page
    lead="Fusion renders every page on the server the first time it loads. Search engines and link previews get complete HTML, with the content, the title, the description and the tags they read."
>
    <p>
        Add <code>@@fusionHead</code> to your layout's <code>&lt;head&gt;</code>. It prints the page's
        <code>&lt;title&gt;</code> and the tags that search engines and link previews read. Each page sets only what
        it needs, and the rest comes from defaults in <code>config/fusion.php</code>.
    </p>

    <h2 id="defaults">Setting defaults</h2>

    <x-docs.code src="head-config.php" highlight="3" />

    <p>
        The <code>title</code> option is the format of every page's <code>&lt;title&gt;</code>. The page's own
        title replaces <code>%s</code>. A page without a title gets <code>app.name</code>.
    </p>

    <h2 id="fixed-text">Setting fixed text</h2>
    <p>If a page's head doesn't depend on its data, set it with attributes:</p>

    <x-docs.code src="head-attributes.php" highlight="4,5" />

    <h2 id="from-data">Setting the head from the page's data</h2>
    <p>If a page's head depends on its data, set it in <code>mount()</code> with <code>$this-&gt;head()</code>:</p>

    <x-docs.code src="head-mount.php" runs="server" />

    <p>Each method prints these tags:</p>

    @php
        $tags = [
            ['`title()`, `#[Title]`', '`<title>` in the `head.title` format, and `og:title`'],
            ['`description()`, `#[Description]`', '`<meta name="description">` and `og:description`'],
            ['`image()`', '`og:image` and a large Twitter card'],
            ['`canonical()`', '`<link rel="canonical">`'],
            ['`noindex()`', '`<meta name="robots" content="noindex">`'],
            ['`meta($name, $content)`', 'Any other `<meta name>`'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Prints']" :rows="$tags" />

    <h2 id="these-docs">How these docs set their head</h2>
    <p>
        This page sets its head in <code>mount()</code>, from the title in the sidebar and the page's lead. The
        title format is <code>'%s · Fusion'</code>:
    </p>

    <x-docs.code src="head-docs.php" file="app/Fusion/Pages/Docs/Show.php" runs="server" />

    <p>For this page, <code>@@fusionHead</code> prints:</p>

    <x-docs.code src="head-output.html" lang="html" />

    <h2 id="visits">Updating the head on a visit</h2>
    <p>
        A <code>fusion:navigate</code> visit brings the new page's head along with its data. The browser replaces
        the previous page's tab title, description and canonical link with the new ones. Move to another page of
        these docs, and the tab's title follows.
    </p>

    <x-docs.callout type="tip" title="Where the head matters">
        <p>Pages behind a login rarely need more than a title. The head matters most for public pages that people search for and share, such as a product, an article or a profile.</p>
    </x-docs.callout>

    <p>
        A layout that writes its own <code>&lt;title&gt;@{{ $title }}&lt;/title&gt;</code> keeps working, because
        <code>$title</code> is the page's title.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/page-data" title="Page data" icon="server" runs="server">Defer, reload and merge properties, and share data with every page.</x-docs.card>
        <x-docs.card href="/docs/production" title="Building for production" icon="bolt">Run fusion:build, and see what a client page's head needs at build time.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

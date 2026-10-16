<x-docs.page
    lead="A page's view can be Vue, React, Solid or Svelte, not only a component's. Then the whole page is one .vue, .jsx or .svelte file, and its PHP class is its controller: routed, loading its data in mount(), doing the server's work in #[Server] methods. Visits move between pages of any framework without a reload."
>
    <p>
        A <a nitro:navigate href="/docs/pages">page</a> is a component with a route, so everything a component's
        JavaScript view can do, a page's can too. What a page adds is its route, its layout, its title and head, and
        data that loads after it shows. This page covers those. Each framework's page covers the view itself.
    </p>

    <h2 id="one-page-four-ways">One page, four ways</h2>
    <p>
        The class names its view with <code>#[View]</code>, as a component does. The rest is the page class you would
        write for Blade:
    </p>

    <x-docs.code src="app/Nitro/Pages/Demo/VuePage.php" file="app/Nitro/Pages/Demo/VuePage.php" runs="both" highlight="16,17,18" />

    <p>
        The four pages differ only in that line: <code>#[View(react: 'demo/page')]</code>,
        <code>#[View(solid: 'demo/page')]</code>, <code>#[View(svelte: 'demo/page')]</code>. Their views are the
        same page in each framework's idiom:
    </p>

    <x-docs.tabs>
        <x-docs.tab label="page.vue">
            <x-docs.code src="resources/views/vue/demo/page.vue" lang="vue" bare />
        </x-docs.tab>
        <x-docs.tab label="page.jsx (React)">
            <x-docs.code src="resources/views/react/demo/page.jsx" lang="jsx" bare />
        </x-docs.tab>
        <x-docs.tab label="page.jsx (Solid)">
            <x-docs.code src="resources/views/solid/demo/page.jsx" lang="jsx" bare />
        </x-docs.tab>
        <x-docs.tab label="page.svelte">
            <x-docs.code src="resources/views/svelte/demo/page.svelte" lang="svelte" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <p>Each is routed like any page:</p>

    <x-docs.code src="js-pages-routes.php" file="routes/web.php" />

    <x-docs.callout type="tip" title="See them running">
        <p>These are the pages at <a href="/demo/vue">/demo/vue</a>, <a href="/demo/react">/demo/react</a>, <a href="/demo/solid">/demo/solid</a> and <a href="/demo/svelte">/demo/svelte</a>. Search, write a post, then follow the links between them: each one is a visit to a page in another framework, not a reload.</p>
    </x-docs.callout>

    <h2 id="layout">The layout stays Blade</h2>
    <p>
        A page renders inside its layout, and the layout is Blade whatever the page's view is: your
        <code>&lt;head&gt;</code> with <code>@@nitroHead</code>, the header and footer, <code>@@nitroScripts</code>.
        The page's view goes where <code>$slot</code> is. <code>#[Layout]</code> chooses the layout, and
        <code>#[Title]</code> the title, as for a Blade page (see <a nitro:navigate href="/docs/pages#layouts">Choosing a layout</a>).
    </p>

    <h2 id="head">The page's head</h2>
    <p>
        <code>$this-&gt;head()</code> in <code>mount()</code> sets the description, the link preview and other tags, as on
        <a nitro:navigate href="/docs/head">The page's head</a>. They are in the first HTML, and a visit puts the new
        page's tags in place of the last page's, whatever either page's view is.
    </p>

    <h2 id="deferred">Deferred properties</h2>
    <p>
        <code>$this-&gt;defer()</code> in <code>mount()</code> sends the page without a slow property, and the page asks
        for it once it is shown (see <a nitro:navigate href="/docs/page-data#deferred">Page data</a>). Until it arrives,
        the view has the property's default, <code>null</code>, so show something meanwhile:
    </p>

    <x-docs.code src="js-pages-defer.php" runs="server" highlight="5" />

    <x-docs.tabs>
        <x-docs.tab label="Vue">
            <x-docs.code src="js-pages-defer.vue" lang="vue" bare />
        </x-docs.tab>
        <x-docs.tab label="React">
            <x-docs.code src="js-pages-defer-react.jsx" lang="jsx" bare />
        </x-docs.tab>
        <x-docs.tab label="Solid">
            <x-docs.code src="js-pages-defer-solid.jsx" lang="jsx" bare />
        </x-docs.tab>
        <x-docs.tab label="Svelte">
            <x-docs.code src="js-pages-defer.svelte" lang="svelte" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <p>What the visitor does while it loads is kept: a click that changed another property stays changed.</p>

    <h2 id="visits">Visits between frameworks</h2>
    <p>
        A <code>nitro:navigate</code> link in Blade, or <code>link()</code> and <code>visit()</code> in a JavaScript view,
        visits a page whatever its view is: from Blade to Vue, from Vue to React, and back. When both
        pages have the same layout, the layout stays and only the page changes. The address and the title follow,
        and back and forward return.
    </p>
    <p>
        If a framework is registered with <code>lazy()</code>, the visit loads it with the page's view before showing
        the page, so a site can have one React page without every other page downloading React (see
        <a nitro:navigate href="/docs/javascript-views#lazy">Loading a framework where it's used</a>).
    </p>

    <x-docs.callout type="note" title="Tested as one">
        <p>Nitro's browser tests load a page with each of the four views and visit it from a Blade page: what <code>mount()</code> set, the title, <code>head()</code>'s tags, a deferred property, a browser method and a <code>#[Server]</code> method from the view, and back.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/vue" title="Vue" icon="browser">Everything a Vue view can use, for a component or a page.</x-docs.card>
        <x-docs.card href="/docs/pages" title="Pages" icon="book">Routes, layouts and loading a page's data.</x-docs.card>
        <x-docs.card href="/docs/coming-from-inertia" title="Coming from Inertia" icon="arrow">A page class as Inertia's page and its controller.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="A page is a whole screen of your application. It is a component with its own route, layout and title, and it loads its data in mount(). The server renders it the first time it loads."
>
    <p>
        Pages live in <code>app/Nitro/Pages</code>, and their views live in
        <code>resources/views/nitro/pages</code>. A page has everything a component has: properties, browser
        methods, <code>#[Server]</code> methods and the same Blade. On top of that, a page has a route, a layout
        around it, and a <code>&lt;head&gt;</code> for search engines and link previews.
    </p>

    <x-docs.callout type="tip" title="You are reading one">
        <p>Every page of these docs is a Nitro page, and you can read <a href="#this-page">its class and view</a> below. When you move between pages with the sidebar, the layout stays and only the page changes.</p>
    </x-docs.callout>

    <h2 id="routing">Routing a page</h2>
    <p>You can route a page by its class or by its name:</p>

    <x-docs.code src="page-routes.php" file="routes/web.php" highlight="3,4" />

    <p>
        <code>Route::nitro()</code> returns a normal Laravel route. Route names, middleware, groups and route
        model binding all work as usual. The page <code>App\Nitro\Pages\Posts\Index</code> is named
        <code>pages::posts.index</code>.
    </p>

    <h2 id="a-page">Writing a page</h2>
    <p>
        <code>php artisan make:nitro Posts/Show --page</code> writes a page's class and view, and prints the route to add
        (see <a nitro:navigate href="/docs/components#make">make:nitro</a>).
    </p>
    <p>
        A page's <code>mount()</code> method receives the route's parameters, with route model binding. The
        <code>#[Title]</code> and <code>#[Layout]</code> attributes control how the page is shown:
    </p>

    <x-docs.code src="page-show.php" file="app/Nitro/Pages/Posts/Show.php" highlight="10,11,19" />

    <ul>
        <li><code>mount(Post $post)</code> runs once, on the server, with the bound model. It stores what the view needs in properties. Here the post is kept as an array and marked <code>#[Locked]</code>, so the browser can't change it.</li>
        <li><code>addComment()</code> is a <code>#[Server]</code> method. It saves the comment with Eloquent and then clears the field.</li>
        <li>Everything else on the page runs in the browser, such as typing the comment or showing and hiding parts of the page.</li>
    </ul>

    <p>
        A page's view can also be Vue, React, Solid or Svelte: <code>#[View(vue: 'posts/show')]</code> makes the whole
        page one <code>.vue</code> file, inside its Blade layout. See
        <a nitro:navigate href="/docs/javascript-pages">Pages with JavaScript views</a>, and the same page built with
        each, starting at <a href="/demo/vue">/demo/vue</a>.
    </p>

    <h2 id="layouts">Choosing a layout</h2>
    <p>
        A page renders inside its layout as <code>$slot</code>, and its title is available as
        <code>$title</code>. If a page has no <code>#[Layout]</code>, it uses the layout set in
        <code>nitro.layout</code>, which is <code>components.layouts.app</code> by default. Your layout needs
        <code>@@nitroHead</code> in its <code>&lt;head&gt;</code> and <code>@@nitroScripts</code> before
        <code>&lt;/body&gt;</code>:
    </p>

    <x-docs.code src="layout.blade.php" lang="blade" file="resources/views/components/layouts/app.blade.php" highlight="6,11" />

    <p>
        When a <a nitro:navigate href="/docs/navigation">nitro:navigate</a> visit goes to a page with the same
        layout, the layout stays and only the page changes. A sidebar keeps its scroll position, and a player
        keeps playing.
    </p>
    <p>
        <code>#[Layout]</code> takes the layout's data as its second argument, as variables in the layout:
        <code>#[Layout('components.layouts.app', ['section' =&gt; 'billing'])]</code>. A page whose layout has other
        data counts as another layout.
    </p>

    <h3 id="nested-layouts">Layouts inside layouts</h3>
    <p>
        A section of your app, such as settings or an account area, often has its own layout around its pages (a
        sub-navigation, a header) inside the app's layout. Write it as a layout that uses the app's, and mark where
        each layout's pages go with <code>nitro:layout</code> and a name:
    </p>

    <x-docs.code src="layout-app-region.blade.php" lang="blade" file="resources/views/components/layouts/app.blade.php" highlight="5" />
    <x-docs.code src="layout-settings.blade.php" lang="blade" file="resources/views/components/layouts/settings.blade.php" highlight="2,10" />

    <p>A page in the section names its layout:</p>

    <x-docs.code src="layout-nested-page.php" file="app/Nitro/Pages/Settings/Billing.php" highlight="4" />

    <p>A visit then changes only the innermost layout region the two pages share:</p>

    @php
        $visits = [
            ['Between two settings pages', 'The settings page. The sub-navigation and the sidebar stay (the same layout)'],
            ['From a dashboard page to a settings page, or back', 'What is inside `nitro:layout="app"`. The sidebar stays'],
            ['To a page in a layout without `nitro:layout="app"`', 'The whole page'],
        ];
    @endphp
    <x-docs.table :columns="['A visit', 'Changes']" :rows="$visits" />

    <ul>
        <li><strong>What stays, stays as it was.</strong> Outside the region, nothing is rendered again: a sidebar keeps its scroll position and what was typed in it, its components keep their state, and its scripts don't run again.</li>
        <li><strong>What changes starts afresh.</strong> Inside the region, the new page's HTML takes the place of the old, and its components start, as on a page load.</li>
        <li><strong>Names, in the same nesting.</strong> Regions match by their names, outermost first, each inside the one before it. The first name the two pages don't share ends the match: the region before it is the one that changes.</li>
        <li><strong>Optional.</strong> Between pages of one layout, a visit keeps the layout without <code>nitro:layout</code>. You only need it where a visit crosses from one layout to another that shares a part of it.</li>
    </ul>

    <x-docs.callout type="tip" title="Mark the app's layout once">
        <p>Put <code>nitro:layout="app"</code> around <code>$slot</code> in your app's layout even before you have a nested one. Every layout built on it then shares the sidebar on a visit, with nothing else to do.</p>
    </x-docs.callout>

    <h2 id="components-and-pages">Choosing between a component and a page</h2>
    <p>Use this table to decide which one to write:</p>

    @php
        $kinds = [
            ['A whole screen, with a URL', 'A page'],
            ['A part placed in a view (a search box, a cart, a table)', 'A component'],
            ['Loads data from the route', 'A page, in `mount()`'],
            ['Used on several screens', 'A component, placed on each'],
        ];
    @endphp
    <x-docs.table :columns="['You need', 'Write']" :rows="$kinds" />

    <p>
        You can't place a page inside a view, and you can't route a component. If you try, Nitro's error
        message tells you what to use instead.
    </p>

    <h2 id="chunks">Loading a page's code</h2>
    <p>
        Nitro compiles each page into a chunk of its own. The browser loads that chunk the first time someone
        visits the page, so a large application doesn't send every page up front. You can change this with
        <code>#[LazyLoad]</code>:
    </p>

    <x-docs.code src="lazy-load.php" />

    <h2 id="this-page">This page</h2>
    <p>
        The docs you are reading are a single Nitro page, <code>Docs\Show</code>, routed as
        <code>/docs/{page}</code>. Its <code>mount()</code> method renders the page's content on the server and
        sets its head. Its view places the live examples as real components.
    </p>

    <x-docs.pair class="app/Nitro/Pages/Docs/Show.php" view="resources/views/nitro/pages/docs/show.blade.php" />
    <x-docs.code src="routes/web.php" file="routes/web.php" highlight="10" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/navigation" title="Navigation" icon="arrow">Move between pages without a reload, and choose how each visit shows a page.</x-docs.card>
        <x-docs.card href="/docs/head" title="The page's head" icon="book">Set titles, descriptions and link previews.</x-docs.card>
        <x-docs.card href="/docs/page-data" title="Page data" icon="server" runs="server">Defer, reload and merge properties, and share data with every page.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

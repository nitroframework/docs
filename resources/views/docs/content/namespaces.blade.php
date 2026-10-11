<x-docs.page
    lead="A module of your app, or a package you publish, can keep its components, pages and stores in folders of its own. It registers them under a namespace, and its components are named with it: billing::invoice-table."
>
    <p>
        By default Nitro finds components in <code>app/Nitro/Components</code>, pages in <code>app/Nitro/Pages</code>
        and stores in <code>app/Nitro/Stores</code>. That suits most apps. A large app split into modules, each
        owning its screens, or a package that ships components, needs its own folders instead. That's what
        <code>nitro.namespaces</code> is for. It works like Blade's view namespaces: Laravel's
        <code>loadViewsFrom(..., 'billing')</code> gives you <code>billing::invoice</code> views, and a Nitro
        namespace gives you <code>billing::invoice-table</code> components.
    </p>

    <h2 id="registering">Registering a namespace</h2>
    <p>
        The module's service provider adds its namespace in <code>register()</code>, and loads its Blade views in
        <code>boot()</code>, as any Laravel package does:
    </p>

    <x-docs.code src="namespaces-provider.php" />

    <p>
        Each part is optional: a module with components only leaves out <code>pages</code> and <code>stores</code>.
        Each takes what <code>nitro.components</code>, <code>nitro.pages</code> and <code>nitro.stores</code> take:
        the classes' PHP namespace, their folder, and for components and pages the prefix of their Blade views.
    </p>

    <ul>
        <li><strong>The name.</strong> A namespace is named in kebab case, such as <code>billing</code> or <code>billing-admin</code>. <code>pages</code> and <code>stores</code> are taken: they start page and store names.</li>
        <li><strong>Views.</strong> A component's view is its name under <code>views</code>: <code>billing::components.invoice-table</code>, from the Blade namespace the provider loads. Without <code>views</code>, it is <code>billing::invoice-table</code>.</li>
        <li><strong>Folders inside folders.</strong> Pages may sit inside the components' folder, as <code>Ui/Components/Pages</code> would. A class belongs to the most specific folder that holds it, so those are pages, not components.</li>
    </ul>

    <h2 id="names">Names</h2>
    <p>A class in the namespace is named as the app's are, with the namespace in front:</p>

    @php
        $names = [
            ['`Billing\Ui\Components\InvoiceTable`', '`billing::invoice-table`'],
            ['`Billing\Ui\Components\Reports\Summary`', '`billing::reports.summary`'],
            ['`Billing\Ui\Pages\Invoices\Index`', '`pages::billing::invoices.index`'],
            ['`Billing\Ui\Stores\Basket`', '`stores::billing::basket`'],
        ];
    @endphp
    <x-docs.table :columns="['Class', 'Name']" :rows="$names" />

    <p>A component is an ordinary Nitro component:</p>

    <x-docs.code src="namespaces-component.php" runs="both" />

    <p>Place it by its name, from any view: the app's, or another module's:</p>

    <x-docs.code src="namespaces-place.blade.php" lang="blade" />

    <p>
        Pages are routed by their class, so their names rarely show. A namespace's page is a chunk of its own, as
        the app's are, named <code>billing.invoices.index</code>:
    </p>

    <x-docs.code src="namespaces-route.php" />

    <p>
        A store is used through a property of its type, as any store is, so its name doesn't show at all. See
        <a nitro:navigate href="/docs/sharing-state">Sharing state</a>.
    </p>

    <h2 id="make">Making components</h2>
    <p>
        <code>make:nitro</code> writes into a namespace when the name has one: the class into its folder, the view
        into the Blade namespace its provider loads.
    </p>

    <x-docs.code src="namespaces-make.sh" lang="sh" />

    <p>
        It stops with a message when the namespace isn't registered, when it has no folder for that kind (a page in a
        namespace without <code>pages</code>), or when its Blade views aren't loaded.
    </p>

    <h2 id="javascript-views">Vue, React, Solid and Svelte views</h2>
    <p>
        A namespace can have <a nitro:navigate href="/docs/javascript-views">JavaScript views</a> too. Give it a
        folder for each engine it uses:
    </p>

    <x-docs.code src="namespaces-vue-config.php" />

    <p>Its components name their views with the namespace:</p>

    <x-docs.code src="namespaces-vue-component.php" />

    <p>
        Nitro finds <code>invoice-chart.vue</code> in the module's folder. Your Vite builds it, so the browser has
        to find it too: give the adapter the module's views with <code>namespaced()</code>, beside the app's.
        Every adapter has it: <code>nitro/vue</code>, <code>nitro/react</code>, <code>nitro/solid</code> and
        <code>nitro/svelte</code>.
    </p>

    <x-docs.code src="namespaces-vite.js" lang="js" />

    <p>
        A view named <code>billing::invoice-chart</code> is looked for among <code>billing</code>'s views only, and
        one without a namespace among the app's only, so two modules can each have an <code>index.vue</code>. A view
        holding its own PHP, in a <code>&lt;php&gt;</code> block, works in a namespace's folder as in the app's, and
        is named in the namespace: <code>billing::invoice-chart</code>.
    </p>

    <h2 id="packages">In a package</h2>
    <p>
        A package registers its namespace the same way, in its own service provider, and ships its components,
        pages and views in its own folders. Name the namespace after the package, so it doesn't meet another's. An
        app that installs it places <code>&lt;nitro:billing::invoice-table /&gt;</code> without copying anything into its
        own folders.
    </p>

    <x-docs.callout type="tip" title="Builds and the cache">
        <code>php artisan nitro:build</code> includes every namespace's components, and its cached list is found
        again when a file is added to any namespace's folder, as with the app's own.
    </x-docs.callout>
</x-docs.page>

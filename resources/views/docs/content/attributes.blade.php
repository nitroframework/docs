<x-docs.page
    lead="Attributes are how you tell Nitro what a part of your component is for. Mark a method #[Server] and it runs on your server instead of in the browser; mark a property #[Locked] and the browser can read it but never change it. This page brings every attribute together, so you can see at a glance what each one does and where to read more."
>
    <h2 id="why">What attributes do</h2>
    <p>
        A Nitro component works without any attributes at all, because Nitro has a sensible default for
        everything. Its public properties are its state: the browser holds them, can change them, and sends them back
        to the server with each call. Its methods run in the browser, compiled from your PHP, so clicks and typing
        feel instant. Its view is the Blade view named after the class. For many components, that is all you need.
    </p>
    <p>
        An attribute changes one of those defaults, for the one thing it is written on. A method that must touch the
        database gets <code>#[Server]</code>. A property the browser should never change, such as an order's id, gets
        <code>#[Locked]</code>. A page that should load its code only when someone visits it gets
        <code>#[LazyLoad]</code>. Because each attribute sits right next to the code it affects, you can read a
        component from top to bottom and see exactly how it behaves.
    </p>
    <p>
        Attributes are PHP's own <code>#[...]</code> annotations, and Nitro's live in the <code>Nitro\Attributes</code>
        namespace. Nitro reads them when it builds your components, not while your page runs. So a mistake, such as
        <code>#[Server]</code> on a method that cannot be called from the browser, stops the build and names the file
        and line, rather than failing later in a visitor's browser.
    </p>

    <h2 id="all">Every attribute</h2>
    <p>
        Here is every attribute, with where it goes and what it changes. The sections after the table show each group
        in a real component, and link to the page that explains it in full.
    </p>

    @php
        $all = [
            ['`#[View]`', 'A component', 'Its view, when it isn\'t the conventional Blade view, or is Vue, React, Solid or Svelte'],
            ['`#[LazyLoad]`', 'A component or page', 'Its code in a chunk of its own, loaded when first needed'],
            ['`#[Layout]`', 'A page', 'The Blade layout it renders in'],
            ['`#[Title]`', 'A page', 'Its title, for the layout'],
            ['`#[Description]`', 'A page', 'Its description, for search results and link previews'],
            ['`#[Navigate]`', 'A page', 'How a visit shows it: data first, markup first, or rendered in the browser'],
            ['`#[Locked]`', 'A property', 'Read in the browser, changed only by the server'],
            ['`#[Validate]`', 'A property', 'Rules the server checks whenever the browser changes it'],
            ['`#[Url]`', 'A property', 'Kept in the query string'],
            ['`#[Remember]`', 'A property', 'Kept in the browser\'s history entry'],
            ['`#[Modelable]`', 'A property', 'The one a parent binds with nitro:model'],
            ['`#[Uploads]`', 'An array property', 'Takes several uploaded files'],
            ['`#[Computed]`', 'A method', 'A value worked out in the browser, read as a property'],
            ['`#[Html]`', 'A method', 'HTML made on the server, placed by the view'],
            ['`#[Server]`', 'A method', 'Runs on the server, called from the browser'],
            ['`#[Cached]`', '`mount()` or a `#[Server]` method', 'Its result kept, for a time or until a tag expires'],
            ['`#[On]`', 'A method', 'Runs when an event is dispatched'],
            ['`#[Persist]`', 'A store or its property', 'Kept in localStorage'],
            ['`#[Sync]`', 'A store or its property', 'Shared with the site\'s other tabs'],
            ['`#[Browser]`', 'Any class', 'Its static methods and constants usable in the browser'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'Goes on', 'What it does']" :rows="$all" />

    <h2 id="on-a-component">On a component</h2>
    <p>
        <a nitro:navigate href="/docs/javascript-views"><code>#[View]</code></a> names a component's view when it
        isn't <code>nitro.components.*</code>, or when it is a Vue, React, Solid or Svelte view.
        <a nitro:navigate href="/docs/pages#chunks"><code>#[LazyLoad]</code></a> leaves the component out of the main
        bundle: the browser loads it when a page first needs it. <code>#[LazyLoad('reports')]</code> puts several
        in one chunk.
    </p>
    <x-docs.code src="attributes-component.php" />

    <h2 id="on-a-page">On a page</h2>
    <p>
        A <a nitro:navigate href="/docs/pages">page</a> is a component with a route. <code>#[Layout]</code> picks
        its layout (with data for it as a second argument), and
        <a nitro:navigate href="/docs/head"><code>#[Title]</code> and <code>#[Description]</code></a> fill its
        <code>&lt;head&gt;</code>. <a nitro:navigate href="/docs/navigation#modes"><code>#[Navigate]</code></a>
        chooses how a visit shows it: <code>'data'</code> (the default) waits for its data,
        <code>'markup'</code> shows it at once and fills it in, <code>'client'</code> renders it in the browser
        without asking the server.
    </p>
    <x-docs.code src="attributes-page.php" />
    <p>These go on pages only: on a component, the build says to move it to the pages namespace.</p>

    <h2 id="on-a-property">On a property</h2>
    <p>
        A public property is state: the browser holds it and can change it. These attributes change what it may
        do. See <a nitro:navigate href="/docs/properties">Properties</a> for <code>#[Locked]</code>,
        <code>#[Url]</code>, <code>#[Remember]</code> and <code>#[Modelable]</code>,
        <a nitro:navigate href="/docs/forms">Forms and validation</a> for <code>#[Validate]</code>, and
        <a nitro:navigate href="/docs/uploads">Uploads</a> for <code>#[Uploads]</code>.
    </p>
    <x-docs.code src="attributes-properties.php" />
    <ul>
        <li><strong><code>#[Url]</code></strong> takes <code>as</code> (the name in the address), <code>history</code> (a history entry per change), <code>keep</code> (keep it when it equals its default) and <code>except</code> (a value left out of the address).</li>
        <li><strong><code>#[Validate]</code></strong> takes Laravel's rules, as a string or an array, and <code>as</code>: the name its messages give the field.</li>
        <li><strong>Model properties</strong> are always locked: the browser can't swap one model for another.</li>
    </ul>

    <h2 id="on-a-method">On a method</h2>
    <p>
        Methods run in the browser unless an attribute says otherwise. <code>#[Server]</code> sends a call to the
        server, with the component's state (<a nitro:navigate href="/docs/server-methods">Server methods</a>).
        <code>#[Computed]</code> is a value worked out in the browser from the state
        (<a nitro:navigate href="/docs/methods#computed">Methods</a>), and <code>#[Html]</code> is HTML made on the
        server for the view to place (<a nitro:navigate href="/docs/html">Server-made HTML</a>). Both are read as
        properties.
    </p>
    <x-docs.code src="attributes-methods.php" />
    <ul>
        <li><strong><code>#[Cached]</code></strong> keeps <code>mount()</code>'s state or a <code>#[Server]</code> method's result, with <code>seconds</code>, <code>tags</code> (expired with <code>Nitro::expire()</code>), <code>perUser</code> and <code>by</code> (<a nitro:navigate href="/docs/caching">Caching</a>).</li>
        <li><strong><code>#[On]</code></strong> can go on a method several times, one event each (<a nitro:navigate href="/docs/events">Events</a>).</li>
        <li><strong><code>#[Computed]</code>, <code>#[Html]</code> and <code>#[Server]</code></strong> are one of each: a method is worked out in the browser, made on the server, or called on the server.</li>
    </ul>

    <h2 id="on-a-store">On a store</h2>
    <p>
        A <a nitro:navigate href="/docs/sharing-state#store">store</a> holds state several components share.
        <code>#[Persist]</code> keeps it in the browser's localStorage, and <code>#[Sync]</code> shares it with the
        site's other tabs. On the class, they cover every property the browser can change; on a property, that one.
    </p>
    <x-docs.code src="attributes-store.php" />

    <h2 id="on-any-class">On any class</h2>
    <p>
        <code>#[Browser]</code> marks a class whose static methods and constants your browser methods and views
        may use, such as formatting money in one place (<a nitro:navigate href="/docs/browser-classes">Browser
        classes and enums</a>).
    </p>
    <x-docs.code src="attributes-browser.php" />

    <h2 id="your-own">Your own attributes</h2>
    <p>
        A class extending <code>Nitro\FeatureAttribute</code> is an attribute of your own that runs code around a
        component, a property or a <code>#[Server]</code> method on the server: logging a call, checking a
        permission. See <a nitro:navigate href="/docs/extending#attribute-classes">Extending Nitro</a>.
    </p>
</x-docs.page>

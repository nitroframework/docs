<x-docs.page
    lead="Write a component's view as a Solid component. The component stays a PHP class: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. The view gets them as reactive props, by their PHP names, and only the parts of the page that read a changed value update."
>
    <p>
        A Solid view is a <code>.jsx</code> or <code>.tsx</code> file your Vite builds with <code>vite-plugin-solid</code>.
        Its default export is a Solid component, and its props are the Nitro component: every property and
        <code>#[Computed]</code> value, every method, and what the component knows about itself (validation messages,
        unsaved changes, uploads, a call's status). Signals, memos, effects, control flow and context work as they
        always do. Nitro takes care of state, the server and navigation, so there is no resource to fetch, no API
        route and no store to set up.
    </p>

    <x-docs.callout type="note" title="Solid 1.x">
        <p>Nitro's Solid adapter uses Solid's public API only: <code>render</code>, <code>hydrate</code>, <code>createStore</code>, <code>reconcile</code>, <code>createMutable</code>, context and <code>renderToString</code>. A Solid release needs nothing from Nitro.</p>
    </x-docs.callout>

    <h2 id="setup">Setting it up</h2>

    <x-docs.steps>
        <x-docs.step title="Install Solid and its Vite plugin">
            <x-docs.code code="npm install solid-js vite-plugin-solid" lang="sh" bare />
        </x-docs.step>
        <x-docs.step title="Add the plugins, and register your views">
            <p><code>nitroSolid()</code> takes your views as <code>import.meta.glob()</code> gives them; each view loads when a page first shows it.</p>
            <x-docs.code src="solid-setup.js" lang="js" bare />
        </x-docs.step>
        <x-docs.step title="Load them before Nitro starts">
            <p>Put <code>@@vite</code> before <code>@@nitroScripts</code> in your layout, so the views are registered when the components start.</p>
            <x-docs.code src="vue-layout.blade.php" lang="blade" bare />
        </x-docs.step>
    </x-docs.steps>

    <p>
        Views live in <code>resources/views/solid</code> or <code>resources/js/solid</code>, as <code>.jsx</code>,
        <code>.tsx</code>, <code>.js</code> or <code>.ts</code>. Subfolders work: <code>#[View(solid: 'blog/editor')]</code>
        is <code>blog/editor.jsx</code>.
    </p>

    <x-docs.callout type="tip" title="Solid and React in one app">
        <p>Both compile <code>.jsx</code>, each its own way, so tell each plugin which files are its own. Keep Solid's components (the view's children too) under a <code>solid</code> folder:</p>
        <x-docs.code src="solid-both.js" lang="js" bare />
    </x-docs.callout>

    <p>
        Only a few pages have Solid views? Register it with
        <code>lazy('solid', () => import('nitro/solid'), ...)</code> instead of <code>nitroSolid()</code>:
        Solid then loads with the first page that shows one of its views. See
        <a nitro:navigate href="/docs/javascript-views#lazy">Loading a framework where it's used</a>.
    </p>

    <h2 id="first-view">A component with a Solid view</h2>
    <p>
        The class is an ordinary Nitro component. <code>#[View(solid: 'post-editor')]</code> says its view is
        <code>post-editor.jsx</code>:
    </p>

    <x-docs.code src="solid-editor.php" file="app/Nitro/Components/Solid/PostEditor.php" runs="both" />

    <p>The view reads what it uses from its props, where it uses it:</p>

    <x-docs.code src="solid-editor.jsx" lang="jsx" file="resources/views/solid/post-editor.jsx" />

    <p>Place it like any component, from a Blade page or layout. The class's folder is part of its name:</p>
    <x-docs.code src="solid-place.blade.php" lang="blade" />

    <p>
        Nothing else is needed. <code>props.set('title', ...)</code> writes the property, and the elements that read
        <code>props.title</code> update. <code>props.addTag()</code> runs in the browser, compiled from the PHP.
        <code>props.save()</code> runs on the server, checks its rules there, and comes back with what it changed.
    </p>

    <x-docs.callout type="tip" title="Nothing to import from Nitro">
        The component arrives as the function's props (<code>props.title</code>), so the view imports nothing from
        Nitro. You import Solid's own helpers (<code>For</code>, <code>Show</code>, <code>createSignal</code>) from
        <code>solid-js</code> when you use them, as in any Solid component. <code>useNitro()</code> from
        <code>nitro/solid</code> is for components deeper inside the view, to reach the Nitro component without
        passing props down (<a href="#components">see below</a>).
    </x-docs.callout>

    <h2 id="pages">A page with a Solid view</h2>
    <p>
        A <a nitro:navigate href="/docs/pages">page</a> can have a Solid view too. Then the whole page is one
        <code>.jsx</code> file, as an Inertia page is, and its class is its controller: it is routed, it loads its
        data in <code>mount()</code>, and its <code>#[Server]</code> methods do the server's work. The layout stays
        Blade, with the page's view where <code>$slot</code> is.
    </p>

    <x-docs.code src="app/Nitro/Pages/Demo/SolidPage.php" file="app/Nitro/Pages/Demo/SolidPage.php" runs="both" highlight="16,17,18" />
    <x-docs.code src="resources/views/solid/demo/page.jsx" lang="jsx" file="resources/views/solid/demo/page.jsx" />
    <x-docs.code code="Route::nitro('/demo/solid', SolidPage::class);" file="routes/web.php" />

    <ul>
        <li><strong>A page like any other.</strong> Its route, <code>#[Title]</code>, <code>#[Layout]</code> and <code>mount()</code> work as on <a nitro:navigate href="/docs/pages">Pages</a>, and <code>$this-&gt;head()</code> as on <a nitro:navigate href="/docs/head">The page's head</a>.</li>
        <li><strong>Deferred properties.</strong> <code>$this-&gt;defer()</code> works as on <a nitro:navigate href="/docs/page-data#deferred">Page data</a>. The view has the property's default (<code>null</code>) until it arrives, so show something meanwhile: <code>{props.stats ?? 'Loading…'}</code>.</li>
        <li><strong>Visits in and out.</strong> A link from a Blade page, or from a page with a Vue, React or Svelte view, visits it without a reload, and back returns.</li>
    </ul>

    <x-docs.callout type="tip" title="See it running">
        <p><a href="/demo/solid">/demo/solid</a> is this page. Search, write a post, then follow its links to the same page with a Vue, React or Svelte view: each one is a visit, not a reload.</p>
    </x-docs.callout>

    <h2 id="props">The props</h2>

    @php
        $props = [
            ['Properties', '`props.title`, `props.tags`', 'The values, by their PHP names. Arrays are arrays or objects, models are objects with their attributes, uploads are `Upload` objects'],
            ['#[Computed] values', '`props.words`', 'Worked out again when what they read changes'],
            ['Browser methods', '`props.addTag(tag)`', 'Run in the browser. They return the method\'s value'],
            ['#[Server] methods', '`props.save()`', 'Run on the server. They return a promise of the method\'s value, and carry the call\'s status'],
            ['`errors`', '`props.errors.title?.[0]`', 'The validation messages, by field, as `$errors` has them in Blade'],
            ['`unsaved`', '`props.unsaved.length`', 'The properties changed in the browser that the server hasn\'t seen yet'],
            ['`uploads`', '`props.uploads.cover?.progress`', 'Each property\'s upload while it runs: `uploading`, `progress` (0 to 100) and `error`'],
            ['`set(path, value)`', '`props.set(\'form.email\', value)`', 'Writes a property, or a key under it'],
            ['`upload(path, files)`', '`props.upload(\'cover\', files)`', 'Uploads files into an `Upload` property'],
            ['`dispatch(event, ...)`', '`props.dispatch(\'saved\', id)`', 'Sends an event to the components listening for it'],
            ['`link(href, ...modifiers)`', '`{...props.link(\'/posts\')}`', 'The attributes of a `nitro:navigate` link'],
            ['`visit(url)`', '`props.visit(\'/posts\')`', 'Goes to a page without reloading'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Example', 'What it is']" :rows="$props" />

    <h2 id="reactivity">Reading props, the Solid way</h2>
    <p>
        The props are a Solid store. Reading <code>props.title</code> inside JSX, a <code>createMemo</code> or a
        <code>createEffect</code> tracks it, and only that place runs again when the title changes. The rest of the
        view stays as it is: a component's function runs once.
    </p>
    <ul>
        <li><strong>Don't destructure them</strong>: <code>const { title } = props</code> reads the title once, and never again. Read <code>props.title</code> where you use it, or use <code>splitProps</code>.</li>
        <li><strong>Deep reads are fine-grained too.</strong> <code>props.form.email</code> updates when the email changes, not when another key of <code>form</code> does. When the server sends a list back, the items that stayed the same keep their elements, so <code>&lt;For&gt;</code> doesn't re-create them.</li>
        <li><strong>The call's status is reactive</strong>: <code>props.save.processing</code> in JSX updates as the call starts and ends.</li>
    </ul>

    <x-docs.code src="solid-reactivity.jsx" lang="jsx" />

    <p>
        Keep in signals what belongs to the view alone: whether a menu is open, the text of a tag not yet added. What
        the server should see, or another component should hear about, belongs on the PHP class.
    </p>

    <h2 id="changing">Changing the component</h2>
    <p>
        Props are read only, as in any Solid component. To change the component, there are two ways, and both write
        the property at once, in the browser:
    </p>
    <ul>
        <li><strong><code>props.set(path, value)</code></strong> writes a property, or a key inside one by its dotted path: <code>props.set('form.email', ...)</code>, <code>props.set('lines.0.quantity', ...)</code>. It is what <code>nitro:model</code> does in Blade.</li>
        <li><strong>A browser method</strong>, which is the PHP you wrote, compiled: <code>props.addTag(tag)</code>, <code>props.removeLine(index)</code>.</li>
    </ul>

    <x-docs.code src="solid-changing.jsx" lang="jsx" />

    <p>
        The server sees these changes with the next <code>#[Server]</code> call, which sends them along. Until then
        they are <code>unsaved</code>. A browser method that changes several properties updates the page once, not
        once per property.
    </p>

    <p>
        A method is called with the arguments you give it: <code>onClick={props.save}</code> works as well as
        <code>onClick={() =&gt; props.save()}</code>. The event Solid passes on its own is left out, since a PHP method
        can't take one.
    </p>

    <h2 id="server">Calling the server</h2>
    <p>
        A <code>#[Server]</code> method returns a promise of its return value. While the call runs, the method itself
        carries its status, reactive like the rest of the props:
    </p>

    @php
        $status = [
            ['`save.processing`', 'The call is running', '`nitro:loading`'],
            ['`save.slow`', 'It has been running for 200 ms', '`nitro:loading.delay`'],
            ['`save.failed`', 'The request itself failed: an error on the server, or no connection', ''],
            ['`save.error`', 'Why it failed, as a message', ''],
        ];
    @endphp
    <x-docs.table :columns="['', 'True while', 'In Blade']" :rows="$status" />

    <x-docs.code src="solid-server-calls.jsx" lang="jsx" />

    <p>
        <strong>Rules that fail are not a failed call.</strong> When <code>$this-&gt;validate()</code> refuses the data,
        the promise resolves with <code>null</code>, and <code>props.errors</code> has the messages by field. Only a
        request that fails, such as a 500, a 403 or no network, rejects the promise and sets <code>failed</code>.
    </p>

    <h3 id="validation">Validation messages</h3>
    <p>
        <code>props.errors</code> holds the messages by field, including nested ones
        (<code>props.errors['lines.0.quantity']</code>). They come from the server when a <code>#[Server]</code> method
        validates, and are cleared for a field once it passes. <code>&lt;Show when={props.errors.title}&gt;</code> shows
        a message only while there is one.
    </p>

    <h3 id="unsaved">Unsaved changes</h3>
    <p>
        <code>props.unsaved</code> lists the properties changed in the browser that the server hasn't seen yet. It is
        empty again once a <code>#[Server]</code> call has taken them:
        <code>&lt;Show when={props.unsaved.length}&gt;Unsaved changes&lt;/Show&gt;</code>.
    </p>

    <h2 id="uploads">Uploading files</h2>
    <p>
        A property of type <code>Upload</code> (or an array with <code>#[Uploads]</code>, for several files) takes
        files. <code>props.upload('cover', files)</code> sends them as soon as they are chosen, and the property becomes
        the uploaded file. <code>props.uploads.cover</code> follows the upload while it runs:
    </p>

    <x-docs.code src="solid-uploads.jsx" lang="jsx" />

    <ul>
        <li><strong>A preview</strong>: <code>cover.temporaryUrl()</code> is a URL the browser can show for an image.</li>
        <li><strong>What it is</strong>: <code>getClientOriginalName()</code>, <code>getClientOriginalExtension()</code>, <code>getSize()</code> and <code>getMimeType()</code>, as on the server.</li>
        <li><strong>Refused files</strong>: a file the <code>nitro.uploads.rules</code> refuse puts the message in <code>props.errors.cover</code>, and the property keeps what it had. The promise resolves with <code>null</code>.</li>
        <li><strong>Several files</strong>: for an <code>#[Uploads]</code> array, <code>props.upload('photos', files)</code> sets the list.</li>
        <li><strong>Keeping them</strong>: the file is stored for good only when a <code>#[Server]</code> method calls <code>$this-&gt;cover-&gt;store(...)</code>, after its rules (<code>image</code>, <code>max:2048</code>) pass.</li>
    </ul>

    <h2 id="navigation">Links and visits</h2>
    <p>
        <code>props.link(href, ...modifiers)</code> gives the attributes of a <code>nitro:navigate</code> link: spread
        them on an <code>&lt;a&gt;</code>, and the visit happens without a reload. (JSX can't write
        <code>nitro:navigate.keypress</code> as an attribute name, which is why it is a function.) The modifiers are
        the ones a Blade link takes: <code>'keypress'</code>, <code>'preserve-scroll'</code>, <code>'transition'</code>, and <code>'prefetch'</code> or <code>'prefetch.visible'</code> (with its times: <code>'prefetch.150ms'</code>), which adds <code>nitro:prefetch</code>.
        To go somewhere from code, call <code>props.visit(url)</code>:
    </p>

    <x-docs.code src="solid-links.jsx" lang="jsx" />

    <h2 id="events">Events</h2>
    <p>
        <code>props.dispatch('event', ...params)</code> sends an event to every component that listens for it with
        <code>#[On('event')]</code>, whatever its view is written in: Blade, Vue, React, Svelte or Solid. To react to an
        event, add an <code>#[On]</code> method to the component's class. It runs in the browser, changes the
        properties, and the view updates.
    </p>
    <p>
        An event dispatched without <code>-&gt;to()</code> also reaches the window, so the view's own code can listen
        for it too. That's useful for a toast or an animation that needs no PHP:
    </p>

    <x-docs.code src="solid-events.jsx" lang="jsx" />

    <h2 id="components">Solid components inside the view</h2>
    <p>
        The view is the root of a Solid tree, so it can render any Solid component: your own, or a library's. A
        component anywhere inside the view reaches the Nitro component with <code>useNitro()</code>, which returns
        the same reactive props the view gets, without passing them down. Read from it in place, as from props:
    </p>

    <x-docs.code src="solid-child.jsx" lang="jsx" />

    <x-docs.callout type="note" title="Nitro components go around a Solid view, not inside it">
        <p>A Solid view can't render <code>&lt;nitro:...&gt;</code> components. Compose them from Blade: a Blade page or component can hold several components with Solid, Vue, React, Svelte and Blade views side by side, and they talk through events and stores.</p>
    </x-docs.callout>

    <h2 id="providers">Context providers</h2>
    <p>
        Each component with a Solid view is its own Solid root, and the view is at its top. Put your providers in the
        view, around what it renders, and every component inside sees them:
    </p>

    <x-docs.code src="solid-providers.jsx" lang="jsx" />

    <p>
        For state that several views on a page share, create it in a module of its own (<code>createRoot</code> with a
        store, say) and import it in each view, or use Nitro's <a href="/docs/sharing-state">stores</a>, which the
        server and other engines see too.
    </p>

    <h2 id="colocated">The PHP in the .jsx file</h2>
    <p>
        A small component can live in one file. Put its class at the top of the <code>.jsx</code> or <code>.tsx</code>
        file, in a <code>&lt;php&gt;</code> block inside a comment, so the file stays plain JavaScript to your tools.
        Nitro makes it a class named after the view. <code>Component</code> and Nitro's attributes need no
        <code>use</code>; anything else does.
    </p>

    <x-docs.code src="solid-colocated.jsx" lang="jsx" file="resources/views/solid/newsletter.jsx" />

    <p>
        Place it by the view's name, <code>&lt;nitro:newsletter /&gt;</code>. An error in the block names the line in
        the <code>.jsx</code> file.
    </p>

    <h2 id="ssr">Server rendering</h2>
    <p>
        With <a href="/docs/server-rendering">server rendering</a> on, the page's first HTML has the Solid view rendered
        in it, and the browser hydrates it. Solid compiles a component differently for each, so turn on
        <code>ssr</code> in its plugin, and add the views to your render service:
    </p>

    <x-docs.code src="solid-ssr.js" lang="js" />

    <ul>
        <li><strong>Code that needs the browser</strong> (<code>window</code>, <code>localStorage</code>, measuring an element) goes in <code>onMount()</code>, which runs only in the browser, as in any server-rendered Solid app.</li>
        <li><strong>On the server, a view only reads.</strong> It can't call methods or <code>set()</code> while it renders.</li>
        <li><strong>Several Solid views on a page</strong> hydrate apart: each is keyed by its component's id, so they don't mix up each other's elements.</li>
        <li><strong>A view that fails to render on the server</strong> is left to the browser, which renders it as it would without server rendering.</li>
    </ul>

    <h2 id="from-blade">Coming from Blade</h2>

    @php
        $equivalents = [
            ['`nitro:model="title"`', '`value={props.title} onInput={(e) => props.set(\'title\', e.currentTarget.value)}`'],
            ['`nitro:model.blur="title"`', '`value={props.title} onChange={(e) => props.set(\'title\', e.currentTarget.value)}`'],
            ['`nitro:click="addTag(\'solid\')"`', '`onClick={() => props.addTag(\'solid\')}`'],
            ['`nitro:submit="save"`', '`onSubmit={(e) => (e.preventDefault(), props.save())}`'],
            ['`nitro:loading` (`nitro:target="save"`)', '`<Show when={props.save.processing}>`'],
            ['`nitro:loading.delay`', '`<Show when={props.save.slow}>`'],
            ['`nitro:loading.attr="disabled"`', '`disabled={props.save.processing}`'],
            ['`nitro:dirty`', '`<Show when={props.unsaved.length}>`'],
            ['`@error(\'title\') {{ $message }} @enderror`', '`{props.errors.title?.[0]}`'],
            ['`nitro:model` on a file input', '`onChange={(e) => props.upload(\'cover\', e.currentTarget.files)}`'],
            ['`<a href="/posts" nitro:navigate>`', '`<a {...props.link(\'/posts\')}>`'],
            ['`$dispatch(\'saved\', $id)`', '`props.dispatch(\'saved\', id)`'],
            ['`$visit(\'/posts\')`', '`props.visit(\'/posts\')`'],
            ['`{{ $this->words }}`', '`{props.words}`'],
        ];
    @endphp
    <x-docs.table :columns="['Blade', 'Solid']" :rows="$equivalents" />

    <h2 id="limits">Good to know</h2>
    <ul>
        <li><strong>The view's root</strong> is rendered inside the component's element, a <code>&lt;div&gt;</code> Nitro puts on the page. Style it from the inside.</li>
        <li><strong>TypeScript</strong>: <code>.tsx</code> views work as usual. The props aren't typed for you yet; describe them with an interface of your own.</li>
        <li><strong>A visit</strong> to a page loads its Solid views' code before the page shows, so the page appears with them rendered, not filling in after it.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="book">How views in Vue, React, Solid and Svelte fit into Nitro, and when to choose one.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server">What a #[Server] method can take, return and check.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

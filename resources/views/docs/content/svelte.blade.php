<x-docs.page
    lead="Write a component's view as a Svelte 5 component. The component stays a PHP class: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. The view takes them from $props() by their PHP names, and they are reactive like any Svelte props."
>
    <p>
        A Svelte view is a <code>.svelte</code> file your Vite builds with <code>@sveltejs/vite-plugin-svelte</code>.
        Its props are the Nitro component: every property and <code>#[Computed]</code> value, every method, and what
        the component knows about itself (validation messages, unsaved changes, uploads, a call's status). Runes,
        blocks, snippets, context and transitions work as they always do. Nitro takes care of state, the server and
        navigation, so there is no <code>load</code> function, no API route and no store to set up.
    </p>

    <x-docs.callout type="note" title="Svelte 5">
        <p>Nitro's Svelte adapter uses Svelte's public API only: <code>mount</code>, <code>hydrate</code>, <code>unmount</code>, <code>getContext</code>, <code>$state</code> and <code>svelte/server</code>'s <code>render</code>. A Svelte release needs nothing from Nitro. The examples here use runes.</p>
    </x-docs.callout>

    <h2 id="setup">Setting it up</h2>

    <x-docs.steps>
        <x-docs.step title="Install Svelte and its Vite plugin">
            <x-docs.code code="npm install svelte @sveltejs/vite-plugin-svelte" lang="sh" bare />
        </x-docs.step>
        <x-docs.step title="Add the plugins, and register your views">
            <p><code>nitroSvelte()</code> takes your views as <code>import.meta.glob()</code> gives them; each view loads when a page first shows it. Svelte's plugin also compiles Nitro's adapter, which is written with runes.</p>
            <x-docs.code src="svelte-setup.js" lang="js" bare />
        </x-docs.step>
        <x-docs.step title="Load them before Nitro starts">
            <p>Put <code>@@vite</code> before <code>@@nitroScripts</code> in your layout, so the views are registered when the components start.</p>
            <x-docs.code src="vue-layout.blade.php" lang="blade" bare />
        </x-docs.step>
    </x-docs.steps>

    <p>
        Views live in <code>resources/views/svelte</code> or <code>resources/js/svelte</code>. Subfolders work:
        <code>#[View(svelte: 'blog/editor')]</code> is <code>blog/editor.svelte</code>. This is plain Svelte, not
        SvelteKit: Laravel does the routing, and Nitro the pages.
    </p>

    <p>
        Only a few pages have Svelte views? Register it with
        <code>lazy('svelte', () => import('nitro/svelte'), ...)</code> instead of <code>nitroSvelte()</code>:
        Svelte then loads with the first page that shows one of its views. See
        <a nitro:navigate href="/docs/javascript-views#lazy">Loading a framework where it's used</a>.
    </p>

    <h2 id="first-view">A component with a Svelte view</h2>
    <p>
        The class is an ordinary Nitro component. <code>#[View(svelte: 'post-editor')]</code> says its view is
        <code>post-editor.svelte</code>:
    </p>

    <x-docs.code src="svelte-editor.php" file="app/Nitro/Components/Svelte/PostEditor.php" runs="both" />

    <p>The view takes what it uses from <code>$props()</code>:</p>

    <x-docs.code src="svelte-editor.svelte" lang="svelte" file="resources/views/svelte/post-editor.svelte" />

    <p>Place it like any component, from a Blade page or layout. The class's folder is part of its name:</p>
    <x-docs.code src="svelte-place.blade.php" lang="blade" />

    <p>
        Nothing else is needed. <code>title</code> is <code>$bindable</code>, so <code>bind:value</code> writes the
        property as you type, and what reads <code>title</code> updates. <code>addTag()</code> runs in the browser, compiled from the PHP.
        <code>save()</code> runs on the server, checks its rules there, and comes back with what it changed.
    </p>

    <x-docs.callout type="tip" title="Nothing to import">
        <code>$props()</code> is a Svelte rune, built into the compiler, so the view imports nothing, from Nitro or
        from Svelte, to read the component. <code>useNitro()</code> from <code>nitro/svelte</code> is for
        components deeper inside the view, to reach the Nitro component without passing props down
        (<a href="#components">see below</a>).
    </x-docs.callout>

    <h2 id="pages">A page with a Svelte view</h2>
    <p>
        A <a nitro:navigate href="/docs/pages">page</a> can have a Svelte view too. Then the whole page is one
        <code>.svelte</code> file, as an Inertia page is, and its class is its controller: it is routed, it loads its
        data in <code>mount()</code>, and its <code>#[Server]</code> methods do the server's work. The layout stays
        Blade, with the page's view where <code>$slot</code> is.
    </p>

    <x-docs.code src="app/Nitro/Pages/Demo/SveltePage.php" file="app/Nitro/Pages/Demo/SveltePage.php" runs="both" highlight="16,17,18" />
    <x-docs.code src="resources/views/svelte/demo/page.svelte" lang="svelte" file="resources/views/svelte/demo/page.svelte" />
    <x-docs.code code="Route::nitro('/demo/svelte', SveltePage::class);" file="routes/web.php" />

    <ul>
        <li><strong>A page like any other.</strong> Its route, <code>#[Title]</code>, <code>#[Layout]</code> and <code>mount()</code> work as on <a nitro:navigate href="/docs/pages">Pages</a>, and <code>$this-&gt;head()</code> as on <a nitro:navigate href="/docs/head">The page's head</a>.</li>
        <li><strong>Deferred properties.</strong> <code>$this-&gt;defer()</code> works as on <a nitro:navigate href="/docs/page-data#deferred">Page data</a>. The view has the property's default (<code>null</code>) until it arrives, so show something meanwhile: <code>{stats ?? 'Loading…'}</code>.</li>
        <li><strong>Visits in and out.</strong> A link from a Blade page, or from a page with a Vue, React or Solid view, visits it without a reload, and back returns.</li>
    </ul>

    <x-docs.callout type="tip" title="See it running">
        <p><a href="/demo/svelte">/demo/svelte</a> is this page. Search, write a post, then follow its links to the same page with a Vue, React or Solid view: each one is a visit, not a reload.</p>
    </x-docs.callout>

    <h2 id="props">The props</h2>

    @php
        $props = [
            ['Properties', '`title`, `tags`', 'The values, by their PHP names. Arrays are arrays or objects, models are objects with their attributes, uploads are `Upload` objects'],
            ['#[Computed] values', '`words`', 'Worked out again when what they read changes'],
            ['Browser methods', '`addTag(tag)`', 'Run in the browser. They return the method\'s value'],
            ['#[Server] methods', '`save()`', 'Run on the server. They return a promise of the method\'s value, and carry the call\'s status'],
            ['`errors`', '`errors.title?.[0]`', 'The validation messages, by field, as `$errors` has them in Blade'],
            ['`unsaved`', '`unsaved.length`', 'The properties changed in the browser that the server hasn\'t seen yet'],
            ['`uploads`', '`uploads.cover?.progress`', 'Each property\'s upload while it runs: `uploading`, `progress` (0 to 100) and `error`'],
            ['`set(path, value)`', '`set(\'form.email\', value)`', 'Writes a property, or a key under it'],
            ['`upload(path, files)`', '`upload(\'cover\', files)`', 'Uploads files into an `Upload` property'],
            ['`dispatch(event, ...)`', '`dispatch(\'saved\', id)`', 'Sends an event to the components listening for it'],
            ['`link(href, ...modifiers)`', '`{...link(\'/posts\')}`', 'The attributes of a `nitro:navigate` link'],
            ['`visit(url)`', '`visit(\'/posts\')`', 'Goes to a page without reloading'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Example', 'What it is']" :rows="$props" />

    <h2 id="runes">Runes and the view's own state</h2>
    <p>
        Destructuring <code>$props()</code> keeps the values reactive, as in any Svelte 5 component: when the component
        changes, what reads that value updates, and nothing else does. Values worked out from props are
        <code>$derived</code>, work that follows them is <code>$effect</code>, and the view's own state is
        <code>$state</code>:
    </p>

    <x-docs.code src="svelte-runes.svelte" lang="svelte" />

    <p>
        Keep in <code>$state</code> what belongs to the view alone: whether a menu is open, the text of a tag not yet
        added. What the server should see, or another component should hear about, belongs on the PHP class.
    </p>

    <h2 id="changing">Changing the component</h2>
    <p>There are three ways, and they all write the property at once, in the browser:</p>
    <ul>
        <li><strong>Bindings on a <code>$bindable</code> property</strong>: <code>bind:value</code>, <code>bind:checked</code>, <code>bind:group</code>, on the property or a key deep inside it (<code>bind:value={form.email}</code>, <code>bind:value={line.quantity}</code> in an <code>{#each}</code>). Assigning the prop (<code>form = {...}</code>) writes it too. It is what <code>nitro:model</code> does in Blade.</li>
        <li><strong><code>set(path, value)</code></strong> writes a property, or a key inside one by its dotted path, without declaring it bindable: <code>set('form.email', '')</code>.</li>
        <li><strong>A browser method</strong>, which is the PHP you wrote, compiled: <code>addTag(tag)</code>, <code>removeLine(index)</code>.</li>
    </ul>

    <x-docs.code src="svelte-changing.svelte" lang="svelte" />

    <x-docs.callout type="warning" title="Declare what you bind with $bindable()">
        <p>As with any Svelte component, a prop is written back only when it is <code>$bindable</code>: <code>let { title = $bindable() } = $props()</code>. Without it, <code>bind:value={title}</code> or <code>title = '...'</code> changes the view's own copy of the prop, and the component never hears of it.</p>
    </x-docs.callout>

    <p>
        The server sees these changes with the next <code>#[Server]</code> call, which sends them along. Until then
        they are <code>unsaved</code>. A browser method that changes several properties updates the view once, not once
        per property.
    </p>

    <p>
        A method is called with the arguments you give it: <code>onclick={save}</code> works as well as
        <code>onclick={() =&gt; save()}</code>. The event Svelte passes on its own is left out, since a PHP method can't
        take one.
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

    <x-docs.code src="svelte-server-calls.svelte" lang="svelte" />

    <p>
        <strong>Rules that fail are not a failed call.</strong> When <code>$this-&gt;validate()</code> refuses the data,
        the promise resolves with <code>null</code>, and <code>errors</code> has the messages by field. Only a request
        that fails, such as a 500, a 403 or no network, rejects the promise and sets <code>failed</code>.
    </p>
    <p>
        Svelte's <code>{#await}</code> block works with the promise too, when you'd rather show its result where it
        lands: <code>{#await saving then said}{said}{/await}</code>.
    </p>

    <h3 id="validation">Validation messages</h3>
    <p>
        <code>errors</code> holds the messages by field, including nested ones (<code>errors['lines.0.quantity']</code>).
        They come from the server when a <code>#[Server]</code> method validates, and are cleared for a field once it
        passes: <code>{#if errors.title}&lt;p&gt;{errors.title[0]}&lt;/p&gt;{/if}</code>.
    </p>

    <h3 id="unsaved">Unsaved changes</h3>
    <p>
        <code>unsaved</code> lists the properties changed in the browser that the server hasn't seen yet. It is empty
        again once a <code>#[Server]</code> call has taken them: <code>{#if unsaved.length}Unsaved changes{/if}</code>.
    </p>

    <h2 id="uploads">Uploading files</h2>
    <p>
        A property of type <code>Upload</code> (or an array with <code>#[Uploads]</code>, for several files) takes
        files. <code>upload('cover', files)</code> sends them as soon as they are chosen, and the property becomes the
        uploaded file. <code>uploads.cover</code> follows the upload while it runs:
    </p>

    <x-docs.code src="svelte-uploads.svelte" lang="svelte" />

    <ul>
        <li><strong>A preview</strong>: <code>cover.temporaryUrl()</code> is a URL the browser can show for an image.</li>
        <li><strong>What it is</strong>: <code>getClientOriginalName()</code>, <code>getClientOriginalExtension()</code>, <code>getSize()</code> and <code>getMimeType()</code>, as on the server.</li>
        <li><strong>Refused files</strong>: a file the <code>nitro.uploads.rules</code> refuse puts the message in <code>errors.cover</code>, and the property keeps what it had. The promise resolves with <code>null</code>.</li>
        <li><strong>Several files</strong>: for an <code>#[Uploads]</code> array, <code>upload('photos', files)</code> sets the list.</li>
        <li><strong>Keeping them</strong>: the file is stored for good only when a <code>#[Server]</code> method calls <code>$this-&gt;cover-&gt;store(...)</code>, after its rules (<code>image</code>, <code>max:2048</code>) pass.</li>
    </ul>

    <h2 id="navigation">Links and visits</h2>
    <p>
        <code>link(href, ...modifiers)</code> gives the attributes of a <code>nitro:navigate</code> link: spread them on
        an <code>&lt;a&gt;</code>, and the visit happens without a reload. (Svelte can't write
        <code>nitro:navigate.keypress</code> as an attribute name, and drops an attribute with no value, which is why
        it is a function.) The modifiers are the ones a Blade link takes:
        <code>'keypress'</code>, <code>'preserve-scroll'</code>, <code>'transition'</code>, and <code>'prefetch'</code> or <code>'prefetch.visible'</code> (with its times: <code>'prefetch.150ms'</code>), which adds <code>nitro:prefetch</code>. To go somewhere from code, call <code>visit(url)</code>:
    </p>

    <x-docs.code src="svelte-links.svelte" lang="svelte" />

    <h2 id="events">Events</h2>
    <p>
        <code>dispatch('event', ...params)</code> sends an event to every component that listens for it with
        <code>#[On('event')]</code>, whatever its view is written in: Blade, Vue, React, Solid or Svelte. To react to an
        event, add an <code>#[On]</code> method to the component's class. It runs in the browser, changes the
        properties, and the view updates.
    </p>
    <p>
        An event dispatched without <code>-&gt;to()</code> also reaches the window, so
        <code>&lt;svelte:window&gt;</code> can listen for it too, and Svelte removes the listener with the view. That's
        useful for a toast or an animation that needs no PHP:
    </p>

    <x-docs.code src="svelte-events.svelte" lang="svelte" />

    <h2 id="components">Svelte components inside the view</h2>
    <p>
        The view is the root of a Svelte tree, so it can render any Svelte component: your own, or a library's. A
        component anywhere inside the view reaches the Nitro component with <code>useNitro()</code>, without passing
        props down. It returns the reactive object the view's props come from, so read from it in place
        (<code>nitro.tags</code>); a value destructured from it is a copy that won't follow. Bindings on it write
        the component, as the view's do: <code>&lt;input bind:value={nitro.title}&gt;</code>.
    </p>

    <x-docs.code src="svelte-child.svelte" lang="svelte" />

    <x-docs.callout type="note" title="Nitro components go around a Svelte view, not inside it">
        <p>A Svelte view can't render <code>&lt;nitro:...&gt;</code> components. Compose them from Blade: a Blade page or component can hold several components with Svelte, Vue, React, Solid and Blade views side by side, and they talk through events and stores.</p>
    </x-docs.callout>

    <h2 id="context">Context</h2>
    <p>
        Each component with a Svelte view is its own Svelte app, and the view is at its top. What the view puts in
        context with <code>setContext()</code>, every component inside it can get:
    </p>

    <x-docs.code src="svelte-context.svelte" lang="svelte" />

    <p>
        For state that several views on a page share, export it from a <code>.svelte.js</code> module (a
        <code>$state</code> object) and import it in each view, or use Nitro's
        <a href="/docs/sharing-state">stores</a>, which the server and other engines see too.
    </p>

    <h2 id="colocated">The PHP in the .svelte file</h2>
    <p>
        A small component can live in one file. Put its class in a <code>&lt;php&gt;</code> block at the top of the
        <code>.svelte</code> file. Nitro makes it a class named after the view, and Nitro's Vite plugin leaves the
        block out of what Svelte compiles. <code>Component</code> and Nitro's attributes need no <code>use</code>;
        anything else does.
    </p>

    <x-docs.code src="svelte-colocated.svelte" lang="svelte" file="resources/views/svelte/newsletter.svelte" />

    <p>
        Place it by the view's name, <code>&lt;nitro:newsletter /&gt;</code>. An error in the block names the line in
        the <code>.svelte</code> file.
    </p>

    <h2 id="ssr">Server rendering</h2>
    <p>
        With <a href="/docs/server-rendering">server rendering</a> on, the page's first HTML has the Svelte view rendered
        in it, and the browser hydrates it. Svelte's plugin compiles the views for the server when Vite builds the
        render service, so nothing changes in your Vite config. Add the views to the service:
    </p>

    <x-docs.code src="svelte-ssr.js" lang="js" />

    <ul>
        <li><strong>Code that needs the browser</strong> (<code>window</code>, <code>localStorage</code>, measuring an element) goes in <code>$effect()</code> or <code>onMount()</code>, which run only in the browser, as in any server-rendered Svelte app.</li>
        <li><strong>On the server, a view only reads.</strong> It can't call methods or <code>set()</code> while it renders.</li>
        <li><strong>A view that fails to render on the server</strong> is left to the browser, which renders it as it would without server rendering.</li>
        <li><strong>Write attribute values out</strong>: <code>data-open="true"</code>, not a bare <code>data-open</code>. Svelte's browser build drops an attribute with no value, so the server's HTML and the browser's would differ.</li>
    </ul>

    <h2 id="from-blade">Coming from Blade</h2>

    @php
        $equivalents = [
            ['`nitro:model="title"`', '`bind:value={title}` (with `title = $bindable()`)'],
            ['`nitro:model.blur="title"`', '`value={title} onchange={(e) => set(\'title\', e.currentTarget.value)}`'],
            ['`nitro:click="addTag(\'svelte\')"`', '`onclick={() => addTag(\'svelte\')}`'],
            ['`nitro:submit="save"`', '`onsubmit={(e) => (e.preventDefault(), save())}`'],
            ['`nitro:loading` (`nitro:target="save"`)', '`{#if save.processing}`'],
            ['`nitro:loading.delay`', '`{#if save.slow}`'],
            ['`nitro:loading.attr="disabled"`', '`disabled={save.processing}`'],
            ['`nitro:dirty`', '`{#if unsaved.length}`'],
            ['`@error(\'title\') {{ $message }} @enderror`', '`{errors.title?.[0]}`'],
            ['`nitro:model` on a file input', '`onchange={(e) => upload(\'cover\', e.currentTarget.files)}`'],
            ['`<a href="/posts" nitro:navigate>`', '`<a {...link(\'/posts\')}>`'],
            ['`$dispatch(\'saved\', $id)`', '`dispatch(\'saved\', id)`'],
            ['`$visit(\'/posts\')`', '`visit(\'/posts\')`'],
            ['`{{ $this->words }}`', '`{words}`'],
        ];
    @endphp
    <x-docs.table :columns="['Blade', 'Svelte']" :rows="$equivalents" />

    <h2 id="limits">Good to know</h2>
    <ul>
        <li><strong>The view's root</strong> is rendered inside the component's element, a <code>&lt;div&gt;</code> Nitro puts on the page. A view's <code>&lt;style&gt;</code> is scoped as usual.</li>
        <li><strong>Transitions</strong>: Svelte's <code>transition:</code> and <code>animate:</code> work inside the view. Blade's <code>nitro:transition</code> is for Blade views.</li>
        <li><strong>TypeScript</strong>: <code>&lt;script lang="ts"&gt;</code> works as usual. The props aren't typed for you yet; describe them with an interface of your own.</li>
        <li><strong>A visit</strong> to a page loads its Svelte views' code before the page shows, so the page appears with them rendered, not filling in after it.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="book">How views in Vue, React, Solid and Svelte fit into Nitro, and when to choose one.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server">What a #[Server] method can take, return and check.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

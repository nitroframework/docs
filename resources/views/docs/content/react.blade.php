<x-docs.page
    lead="Write a component's view as a React function component. The component stays a PHP class: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. The view gets them all as props, by their PHP names, and re-renders when they change."
>
    <p>
        A React view is a <code>.jsx</code> or <code>.tsx</code> file your Vite builds with
        <code>@vitejs/plugin-react</code>. Its default export is a function component, and its props are the Nitro
        component: every property and <code>#[Computed]</code> value, every method, and what the component knows
        about itself (validation messages, unsaved changes, uploads, a call's status). Hooks, context, effects and
        any React library work as they always do. Nitro takes care of state, the server and navigation, so there is
        no fetch to write, no API route and no store to set up.
    </p>

    <x-docs.callout type="note" title="React 18 and 19">
        <p>Nitro's React adapter uses React's public API only: <code>createRoot</code>, <code>hydrateRoot</code>, <code>useSyncExternalStore</code>, context and <code>renderToString</code>. A React release needs nothing from Nitro.</p>
    </x-docs.callout>

    <h2 id="setup">Setting it up</h2>

    <x-docs.steps>
        <x-docs.step title="Install React and its Vite plugin">
            <x-docs.code code="npm install react react-dom @vitejs/plugin-react" lang="sh" bare />
        </x-docs.step>
        <x-docs.step title="Add the plugins, and register your views">
            <p><code>nitroReact()</code> takes your views as <code>import.meta.glob()</code> gives them; each view loads when a page first shows it.</p>
            <x-docs.code src="react-setup.js" lang="js" bare />
        </x-docs.step>
        <x-docs.step title="Load them before Nitro starts">
            <p>Put <code>@@vite</code> before <code>@@nitroScripts</code> in your layout, so the views are registered when the components start.</p>
            <x-docs.code src="vue-layout.blade.php" lang="blade" bare />
        </x-docs.step>
    </x-docs.steps>

    <p>
        Views live in <code>resources/views/react</code> or <code>resources/js/react</code>, as <code>.jsx</code>,
        <code>.tsx</code>, <code>.js</code> or <code>.ts</code>. Subfolders work: <code>#[View(react: 'blog/editor')]</code>
        is <code>blog/editor.jsx</code>.
    </p>

    <h2 id="first-view">A component with a React view</h2>
    <p>
        The class is an ordinary Nitro component. <code>#[View(react: 'post-editor')]</code> says its view is
        <code>post-editor.jsx</code>:
    </p>

    <x-docs.code src="react-editor.php" file="app/Nitro/Components/React/PostEditor.php" runs="both" />

    <p>The view takes what it uses from its props:</p>

    <x-docs.code src="react-editor.jsx" lang="jsx" file="resources/views/react/post-editor.jsx" />

    <p>Place it like any component, from a Blade page or layout. The class's folder is part of its name:</p>
    <x-docs.code src="react-place.blade.php" lang="blade" />

    <p>
        Nothing else is needed. <code>set('title', ...)</code> writes the property and the view re-renders with it.
        <code>addTag()</code> runs in the browser, compiled from the PHP. <code>save()</code> runs on the server,
        checks its rules there, and comes back with what it changed: the new <code>savedAt</code>, the cleared
        <code>cover</code>, the messages in <code>errors</code>.
    </p>

    <x-docs.callout type="tip" title="Nothing to import from Nitro">
        The component arrives as the function's props, so the view imports nothing from Nitro. It doesn't import
        React either: the JSX transform Vite's React plugin uses needs no import. You import React's own hooks
        (<code>useState</code>, <code>useEffect</code>) from <code>react</code> when you use them, as in any React
        component. <code>useNitro()</code> from <code>nitro/react</code> is for components deeper inside the view,
        to reach the Nitro component without passing props down (<a href="#components">see below</a>).
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

    <p>
        The props are a snapshot. Each change makes a new one, so the view re-renders as it would for any new props,
        and <code>useMemo</code>, <code>useEffect</code> and <code>memo()</code> compare them as usual. Functions keep
        their identity from one render to the next, so passing <code>save</code> or <code>set</code> to a memoised
        child doesn't re-render it.
    </p>

    <p>
        A method is called with the arguments you give it: <code>onClick={save}</code> works as well as
        <code>onClick={() =&gt; save()}</code>. The event React passes on its own is left out, since a PHP method
        can't take one.
    </p>

    <h2 id="hooks">Hooks and the view's own state</h2>
    <p>
        The view is a function component, so the view's own state is <code>useState</code>, values worked out from
        props are <code>useMemo</code>, and work that follows a value is <code>useEffect</code> with that prop in its
        dependencies:
    </p>

    <x-docs.code src="react-hooks.jsx" lang="jsx" />

    <p>
        Keep in <code>useState</code> what belongs to the view alone: whether a menu is open, the text of a tag not yet
        added. What the server should see, or another component should hear about, belongs on the PHP class.
    </p>

    <h2 id="changing">Changing the component</h2>
    <p>
        Props are read only, as in any React component. To change the component, there are two ways, and both write
        the property at once, in the browser:
    </p>
    <ul>
        <li><strong><code>set(path, value)</code></strong> writes a property, or a key inside one by its dotted path: <code>set('form.email', ...)</code>, <code>set('lines.0.quantity', ...)</code>. It is what <code>nitro:model</code> does in Blade.</li>
        <li><strong>A browser method</strong>, which is the PHP you wrote, compiled: <code>addTag(tag)</code>, <code>removeLine(index)</code>.</li>
    </ul>

    <x-docs.code src="react-changing.jsx" lang="jsx" />

    <p>
        <strong>Controlled inputs work as you'd expect.</strong> <code>set()</code> writes and re-renders at once, in
        the same event, so the caret stays where it was while typing. Don't change an array or object prop in place
        (<code>tags.push(...)</code>): like any React state, it is a snapshot, and only <code>set()</code> or a method
        changes the component.
    </p>
    <p>
        The server sees these changes with the next <code>#[Server]</code> call, which sends them along. Until then
        they are <code>unsaved</code>. A browser method that changes several properties gives React one render, not
        one per property.
    </p>

    <h2 id="server">Calling the server</h2>
    <p>
        A <code>#[Server]</code> method returns a promise of its return value. While the call runs, the method itself
        carries its status, so a button can follow it without a <code>useState</code> of your own:
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

    <x-docs.code src="react-server-calls.jsx" lang="jsx" />

    <p>
        <strong>Rules that fail are not a failed call.</strong> When <code>$this-&gt;validate()</code> refuses the data,
        the promise resolves with <code>null</code>, and <code>errors</code> has the messages by field. Only a request
        that fails, such as a 500, a 403 or no network, rejects the promise and sets <code>failed</code>.
    </p>

    <h3 id="validation">Validation messages</h3>
    <p>
        <code>errors</code> holds the messages by field, including nested ones (<code>errors['lines.0.quantity']</code>).
        They come from the server when a <code>#[Server]</code> method validates, and are cleared for a field once
        it passes. Show the first one with <code>{errors.title?.[0]}</code>.
    </p>

    <h3 id="unsaved">Unsaved changes</h3>
    <p>
        <code>unsaved</code> lists the properties changed in the browser that the server hasn't seen yet. It is empty
        again once a <code>#[Server]</code> call has taken them:
        <code>{unsaved.length &gt; 0 &amp;&amp; &lt;span&gt;Unsaved changes&lt;/span&gt;}</code>.
    </p>

    <h2 id="uploads">Uploading files</h2>
    <p>
        A property of type <code>Upload</code> (or an array with <code>#[Uploads]</code>, for several files) takes
        files. <code>upload('cover', files)</code> sends them as soon as they are chosen, and the property becomes the
        uploaded file. <code>uploads.cover</code> follows the upload while it runs:
    </p>

    <x-docs.code src="react-uploads.jsx" lang="jsx" />

    <ul>
        <li><strong>A preview</strong>: <code>cover.temporaryUrl()</code> is a URL the browser can show for an image.</li>
        <li><strong>What it is</strong>: <code>getClientOriginalName()</code>, <code>getClientOriginalExtension()</code>, <code>getSize()</code> and <code>getMimeType()</code>, as on the server.</li>
        <li><strong>Refused files</strong>: a file the <code>nitro.uploads.rules</code> refuse puts the message in <code>errors.cover</code>, and the property keeps what it had. The promise resolves with <code>null</code>.</li>
        <li><strong>Several files</strong>: for an <code>#[Uploads]</code> array, <code>upload('photos', files)</code> sets the list.</li>
        <li><strong>Keeping them</strong>: the file is stored for good only when a <code>#[Server]</code> method calls <code>$this-&gt;cover-&gt;store(...)</code>, after its rules (<code>image</code>, <code>max:2048</code>) pass.</li>
    </ul>

    <h2 id="navigation">Links and visits</h2>
    <p>
        <code>link(href, ...modifiers)</code> gives the attributes of a <code>nitro:navigate</code> link: spread them
        on an <code>&lt;a&gt;</code>, and the visit happens without a reload. (JSX can't write
        <code>nitro:navigate.prefetch</code> as an attribute name, which is why it is a function.) The modifiers are
        the ones a Blade link takes: <code>'prefetch'</code>, <code>'keypress'</code>, <code>'preserve-scroll'</code>.
        To go somewhere from code, call <code>visit(url)</code>:
    </p>

    <x-docs.code src="react-links.jsx" lang="jsx" />

    <h2 id="events">Events</h2>
    <p>
        <code>dispatch('event', ...params)</code> sends an event to every component that listens for it with
        <code>#[On('event')]</code>, whatever its view is written in: Blade, Vue, Solid, Svelte or React. To react to
        an event, add an <code>#[On]</code> method to the component's class. It runs in the browser, changes the
        properties, and the view re-renders.
    </p>
    <p>
        An event dispatched without <code>-&gt;to()</code> also reaches the window, so an effect can listen for it
        too. That's useful for a toast or an animation that needs no PHP:
    </p>

    <x-docs.code src="react-events.jsx" lang="jsx" />

    <h2 id="components">React components inside the view</h2>
    <p>
        The view is the root of a React tree, so it can render any React component: your own, or a library's. A
        component anywhere inside the view reaches the Nitro component with the <code>useNitro()</code> hook, which
        returns the same props the view gets, without passing them down:
    </p>

    <x-docs.code src="react-child.jsx" lang="jsx" />

    <x-docs.callout type="note" title="Nitro components go around a React view, not inside it">
        <p>A React view can't render <code>&lt;nitro:...&gt;</code> components. Compose them from Blade: a Blade page or component can hold several components with React, Vue, Solid, Svelte and Blade views side by side, and they talk through events and stores.</p>
    </x-docs.callout>

    <h2 id="providers">Providers: React Query, i18n, a theme</h2>
    <p>
        Each component with a React view is its own React root. <code>nitroReact()</code>'s <code>wrap(view)</code> puts
        your providers around each one. Create a client once, outside <code>wrap</code>, and every view on the page
        shares it. (With JSX in it, the file is <code>app.jsx</code>.)
    </p>

    <x-docs.code src="react-providers.jsx" lang="jsx" />

    <h2 id="colocated">The PHP in the .jsx file</h2>
    <p>
        A small component can live in one file. Put its class at the top of the <code>.jsx</code> or <code>.tsx</code>
        file, in a <code>&lt;php&gt;</code> block inside a comment, so the file stays plain JavaScript to your tools.
        Nitro makes it a class named after the view. <code>Component</code> and Nitro's attributes need no
        <code>use</code>; anything else does.
    </p>

    <x-docs.code src="js-views-colocated.jsx" lang="jsx" file="resources/views/react/invite-form.jsx" />

    <p>
        Place it by the view's name, <code>&lt;nitro:invite-form /&gt;</code>. An error in the block names the line in
        the <code>.jsx</code> file.
    </p>

    <h2 id="ssr">Server rendering</h2>
    <p>
        With <a href="/docs/server-rendering">server rendering</a> on, the page's first HTML has the React view rendered
        in it, and the browser hydrates it with <code>hydrateRoot()</code>. Add the views to your render service, with
        the same providers:
    </p>

    <x-docs.code src="react-ssr.jsx" lang="jsx" />

    <ul>
        <li><strong>Code that needs the browser</strong> (<code>window</code>, <code>localStorage</code>, measuring an element) goes in <code>useEffect()</code>, which runs only in the browser, as in any server-rendered React app.</li>
        <li><strong>On the server, a view only reads.</strong> It can't call methods or <code>set()</code> while it renders.</li>
        <li><strong>A view that fails to render on the server</strong> is left to the browser, which renders it as it would without server rendering.</li>
        <li><strong>The first render matches.</strong> The server renders from the same snapshot the browser's first render reads, so hydration finds what it expects. Keep values that differ between the two (the time, a random id) out of the first render, or use <code>useId()</code>.</li>
    </ul>

    <h2 id="from-blade">Coming from Blade</h2>

    @php
        $equivalents = [
            ['`nitro:model="title"`', '`value={title} onChange={(e) => set(\'title\', e.target.value)}`'],
            ['`nitro:model.blur="title"`', '`defaultValue={title} onBlur={(e) => set(\'title\', e.target.value)}`'],
            ['`nitro:click="addTag(\'react\')"`', '`onClick={() => addTag(\'react\')}`'],
            ['`nitro:submit="save"`', '`onSubmit={(e) => { e.preventDefault(); save(); }}`'],
            ['`nitro:loading` (`nitro:target="save"`)', '`{save.processing && ...}`'],
            ['`nitro:loading.delay`', '`{save.slow && ...}`'],
            ['`nitro:loading.attr="disabled"`', '`disabled={save.processing}`'],
            ['`nitro:dirty`', '`{unsaved.length > 0 && ...}`'],
            ['`@error(\'title\') {{ $message }} @enderror`', '`{errors.title?.[0]}`'],
            ['`nitro:model` on a file input', '`onChange={(e) => upload(\'cover\', e.target.files)}`'],
            ['`<a href="/posts" nitro:navigate>`', '`<a {...link(\'/posts\')}>`'],
            ['`$dispatch(\'saved\', $id)`', '`dispatch(\'saved\', id)`'],
            ['`$visit(\'/posts\')`', '`visit(\'/posts\')`'],
            ['`{{ $this->words }}`', '`{words}`'],
        ];
    @endphp
    <x-docs.table :columns="['Blade', 'React']" :rows="$equivalents" />

    <h2 id="limits">Good to know</h2>
    <ul>
        <li><strong>The view's root</strong> is rendered inside the component's element, a <code>&lt;div&gt;</code> Nitro puts on the page. Style it from the inside.</li>
        <li><strong>Several React views on a page</strong> are separate React roots. Share state between them with Nitro's <a href="/docs/sharing-state">stores</a> or events, or with a client created once (React Query, Zustand) that all of them import.</li>
        <li><strong>TypeScript</strong>: <code>.tsx</code> views work as usual. The props aren't typed for you yet; describe them with an interface of your own.</li>
        <li><strong>A visit</strong> to a page loads its React views' code before the page shows, so the page appears with them rendered, not filling in after it.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="book">How views in Vue, React, Solid and Svelte fit into Nitro, and when to choose one.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server">What a #[Server] method can take, return and check.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

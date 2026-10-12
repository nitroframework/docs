<x-docs.page
    lead="Write a component's view as a Vue single-file component. The component stays a PHP class: its properties, its methods compiled to run in the browser, its #[Server] methods and their rules. The template reads them by their PHP names, v-model writes them, and Vue renders."
>
    <p>
        A Vue view is a <code>.vue</code> file your Vite builds with <code>@vitejs/plugin-vue</code>, like any other
        Vue component. Nitro gives it the component: every property and <code>#[Computed]</code> value, every
        method, and what the component knows about itself (validation messages, unsaved changes, uploads, a call's
        status). You write templates, <code>v-model</code>, <code>&lt;script setup&gt;</code> and composables as you
        always do. Nitro takes care of state, the server and navigation.
    </p>

    <x-docs.callout type="note" title="Vue 3">
        <p>Nitro's Vue adapter uses Vue 3's public API only: <code>createApp</code>, <code>createSSRApp</code>, refs, <code>computed</code>, <code>watch</code>, <code>provide</code>/<code>inject</code>. A Vue 3 release needs nothing from Nitro.</p>
    </x-docs.callout>

    <h2 id="setup">Setting it up</h2>

    <x-docs.steps>
        <x-docs.step title="Install Vue and its Vite plugin">
            <x-docs.code code="npm install vue @vitejs/plugin-vue" lang="sh" bare />
        </x-docs.step>
        <x-docs.step title="Add the plugins, and register your views">
            <p>Nitro's Vite plugin goes before Vue's. <code>nitroVue()</code> takes your views as <code>import.meta.glob()</code> gives them; each view loads when a page first shows it.</p>
            <x-docs.code src="vue-setup.js" lang="js" bare />
        </x-docs.step>
        <x-docs.step title="Load them before Nitro starts">
            <p>Put <code>@@vite</code> before <code>@@nitroScripts</code> in your layout, so the views are registered when the components start.</p>
            <x-docs.code src="vue-layout.blade.php" lang="blade" bare />
        </x-docs.step>
    </x-docs.steps>

    <p>
        Views live in <code>resources/views/vue</code> or <code>resources/js/vue</code>, whichever you prefer
        (both are in the <code>nitro.views</code> config). Subfolders work: <code>#[View(vue: 'blog/editor')]</code> is
        <code>blog/editor.vue</code>.
    </p>

    <p>
        Only a few pages have Vue views? Register it with
        <code>lazy('vue', () => import('nitro/vue'), ...)</code> instead of <code>nitroVue()</code>:
        Vue then loads with the first page that shows one of its views. See
        <a nitro:navigate href="/docs/javascript-views#lazy">Loading a framework where it's used</a>.
    </p>

    <h2 id="first-view">A component with a Vue view</h2>
    <p>
        The class is an ordinary Nitro component. <code>#[View(vue: 'post-editor')]</code> says its view is
        <code>post-editor.vue</code>:
    </p>

    <x-docs.code src="vue-editor.php" file="app/Nitro/Components/Vue/PostEditor.php" runs="both" />

    <p>The template uses the component's names as they are, as a Blade view does:</p>

    <x-docs.code src="vue-editor.vue" lang="vue" file="resources/views/vue/post-editor.vue" />

    <p>Place it like any component, from a Blade page or layout. The class's folder is part of its name:</p>
    <x-docs.code src="vue-place.blade.php" lang="blade" />

    <p>
        Nothing else is needed: no props to declare, no store, no API. <code>v-model="title"</code> writes the
        property. <code>addTag()</code> runs in the browser, compiled from the PHP. <code>save()</code> runs on the
        server, checks its rules there, and comes back with what it changed.
    </p>

    <x-docs.callout type="tip" title="No script, nothing to import">
        The file above is the whole view: a <code>&lt;template&gt;</code> and nothing else. There is no
        <code>&lt;script&gt;</code> to write and nothing to import from Nitro, because the template reads the
        component's names directly. Add a <code>&lt;script setup&gt;</code> only when your own script needs them,
        for example to combine them with your own <code>ref()</code>s, <code>computed()</code>s or
        <code>watch()</code>es. Then you import <code>useNitro</code> from <code>nitro/vue</code>
        (<a href="#script-setup">see below</a>).
    </x-docs.callout>

    <h2 id="names">What the view can use</h2>

    @php
        $names = [
            ['Properties', '`title`, `tags`', 'Read and written by their PHP names. Arrays are arrays or objects, models are objects with their attributes, uploads are `Upload` objects'],
            ['#[Computed] values', '`words`', 'Read only. Worked out again when what they read changes'],
            ['Browser methods', '`addTag(tag)`', 'Run in the browser. They return the method\'s value'],
            ['#[Server] methods', '`save()`', 'Run on the server. They return a promise of the method\'s value, and carry the call\'s status'],
            ['`errors`', '`errors.title?.[0]`', 'The validation messages, by field, as `$errors` has them in Blade'],
            ['`unsaved`', '`unsaved.length`', 'The properties changed in the browser that the server hasn\'t seen yet'],
            ['`uploads`', '`uploads.cover?.progress`', 'Each property\'s upload while it runs: `uploading`, `progress` (0 to 100) and `error`'],
            ['`set(path, value)`', '`set(\'form.email\', value)`', 'Writes a property, or a key under it'],
            ['`upload(path, files)`', '`upload(\'cover\', files)`', 'Uploads files into an `Upload` property'],
            ['`dispatch(event, ...)`', '`dispatch(\'saved\', id)`', 'Sends an event to the components listening for it'],
            ['`link(href, ...modifiers)`', '`v-bind="link(\'/posts\')"`', 'The attributes of a `nitro:navigate` link'],
            ['`visit(url)`', '`visit(\'/posts\')`', 'Goes to a page without reloading'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Example', 'What it is']" :rows="$names" />

    <p>
        A method is called with the arguments you give it: <code>@@click="save"</code> works as well as
        <code>@@click="save()"</code>. The event Vue passes on its own is left out, since a PHP method can't take one.
    </p>

    <h2 id="script-setup">In &lt;script setup&gt;</h2>
    <p>
        A view doesn't need a script. Add a <code>&lt;script setup&gt;</code> when your own code needs the
        component, and import <code>useNitro</code> from <code>nitro/vue</code> there.
        <code>useNitro()</code> gives the same names to your script. Properties and <code>#[Computed]</code> values
        are refs, so you use <code>.value</code> in the script and the bare name in the template, as with any ref.
        Assigning a property's ref writes the property. <code>errors</code>, <code>unsaved</code> and
        <code>uploads</code> are refs too; the methods are plain functions.
    </p>

    <x-docs.code src="vue-script-setup.vue" lang="vue" />

    <p>
        Your own <code>ref()</code>s, <code>computed()</code>s and <code>watch()</code>es work alongside: here
        <code>tag</code> and <code>said</code> are the view's own state, and <code>readingTime</code> follows the
        component's <code>words</code>.
    </p>

    <h2 id="changing">Changing the component</h2>
    <p>There are three ways, and they all write the property at once, in the browser:</p>
    <ul>
        <li><strong><code>v-model</code></strong> on a property, or deep inside one: <code>v-model="form.email"</code>, <code>v-model="lines[i].quantity"</code>. Its modifiers (<code>.number</code>, <code>.trim</code>, <code>.lazy</code>) are Vue's own.</li>
        <li><strong>Assigning its ref</strong> in the script: <code>title.value = 'Draft'</code>, <code>tags.value.push('vue')</code>.</li>
        <li><strong>A browser method</strong>, which is the PHP you wrote, compiled: <code>addTag(tag)</code>.</li>
    </ul>
    <p>
        The server sees these changes with the next <code>#[Server]</code> call, which sends them along. Until then
        they are <code>unsaved</code>. A browser method that changes several properties gives Vue one update, not one
        per property.
    </p>

    <h2 id="server">Calling the server</h2>
    <p>
        A <code>#[Server]</code> method returns a promise of its return value. While the call runs, the method itself
        carries its status, so a button can follow it without any state of your own:
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

    <x-docs.code src="vue-server-calls.vue" lang="vue" />

    <p>
        <strong>Rules that fail are not a failed call.</strong> When <code>$this-&gt;validate()</code> refuses the data,
        the promise resolves with <code>null</code>, and <code>errors</code> has the messages by field. Only a request
        that fails, such as a 500, a 403 or no network, rejects the promise and sets <code>failed</code>.
    </p>

    <h3 id="validation">Validation messages</h3>
    <p>
        <code>errors</code> holds the messages by field, including nested ones (<code>errors['lines.0.qty']</code>).
        They come from the server when a <code>#[Server]</code> method validates, and are cleared for a field once
        it passes. Show the first one with <code>errors.title?.[0]</code>.
    </p>

    <h3 id="unsaved">Unsaved changes</h3>
    <p>
        <code>unsaved</code> lists the properties changed in the browser that the server hasn't seen yet. It is empty
        again once a <code>#[Server]</code> call has taken them. Use it to warn before leaving, or to show that a
        draft needs saving: <code>&lt;span v-if="unsaved.length"&gt;Unsaved changes&lt;/span&gt;</code>.
    </p>

    <h2 id="uploads">Uploading files</h2>
    <p>
        A property of type <code>Upload</code> (or an array with <code>#[Uploads]</code>, for several files) takes
        files. <code>upload('cover', files)</code> sends them as soon as they are chosen, and the property becomes the
        uploaded file. <code>uploads.cover</code> follows the upload while it runs:
    </p>

    <x-docs.code src="vue-uploads.vue" lang="vue" />

    <ul>
        <li><strong>A preview</strong>: <code>cover.temporaryUrl()</code> is a URL the browser can show for an image.</li>
        <li><strong>What it is</strong>: <code>getClientOriginalName()</code>, <code>getClientOriginalExtension()</code>, <code>getSize()</code> and <code>getMimeType()</code>, as on the server.</li>
        <li><strong>Refused files</strong>: a file the <code>nitro.uploads.rules</code> refuse puts the message in <code>errors.cover</code>, and the property keeps what it had. The promise resolves with <code>null</code>.</li>
        <li><strong>Several files</strong>: for an <code>#[Uploads]</code> array, <code>upload('photos', files)</code> sets the list.</li>
        <li><strong>Keeping them</strong>: the file is stored for good only when a <code>#[Server]</code> method calls <code>$this-&gt;cover-&gt;store(...)</code>, after its rules (<code>image</code>, <code>max:2048</code>) pass.</li>
    </ul>

    <h2 id="navigation">Links and visits</h2>
    <p>
        <code>link(href, ...modifiers)</code> gives the attributes of a <code>nitro:navigate</code> link, so the visit
        happens without a reload. Bind them with <code>v-bind</code>. The modifiers are the ones a Blade link takes:
        <code>'keypress'</code>, <code>'preserve-scroll'</code>, <code>'transition'</code>, and <code>'prefetch'</code> or <code>'prefetch.visible'</code> (with its times: <code>'prefetch.150ms'</code>), which adds <code>nitro:prefetch</code>. To go somewhere from code,
        call <code>visit(url)</code>:
    </p>

    <x-docs.code src="vue-links.vue" lang="vue" />

    <h2 id="events">Events</h2>
    <p>
        <code>dispatch('event', ...params)</code> sends an event to every component that listens for it with
        <code>#[On('event')]</code>, whatever its view is written in: Blade, React, Solid, Svelte or Vue. To react to
        an event, add an <code>#[On]</code> method to the component's class. It runs in the browser, changes the
        properties, and the view follows.
    </p>
    <p>
        An event dispatched without <code>-&gt;to()</code> also reaches the window, so the view's own code can hear
        it too. That's useful for a notification or an animation that needs no PHP:
    </p>

    <x-docs.code src="vue-events.vue" lang="vue" />

    <h2 id="components">Vue components inside the view</h2>
    <p>
        The view is the root of a Vue app, so it can use any Vue component: your own, or a library's. A component
        inside the view reaches the Nitro component with <code>useNitro()</code>, without passing props down:
    </p>

    <x-docs.code src="vue-child.vue" lang="vue" />

    <x-docs.callout type="note" title="Nitro components go around a Vue view, not inside it">
        <p>A Vue view can't place <code>&lt;nitro:...&gt;</code> components. Compose them from Blade: a Blade page or component can hold several components with Vue, React, Solid, Svelte and Blade views side by side, and they talk through events and stores.</p>
    </x-docs.callout>

    <h2 id="plugins">Plugins: Pinia, i18n, a UI library</h2>
    <p>
        Each component with a Vue view is its own Vue app. <code>nitroVue()</code>'s <code>setup(app)</code> runs for
        each one before it mounts, so install your plugins there. Pass the same Pinia instance to all of them, and
        their stores are shared across the page:
    </p>

    <x-docs.code src="vue-plugins.js" lang="js" />

    <h2 id="colocated">The PHP in the .vue file</h2>
    <p>
        A small component can live in one file. Put its class in a <code>&lt;php&gt;</code> block at the top of the
        <code>.vue</code> file. Nitro makes it a class named after the view, and Nitro's Vite plugin leaves the block
        out of what Vue compiles. <code>Component</code> and Nitro's attributes need no <code>use</code>; anything
        else does.
    </p>

    <x-docs.code src="vue-colocated.vue" lang="vue" file="resources/views/vue/newsletter.vue" />

    <p>
        Place it by the view's name, <code>&lt;nitro:newsletter /&gt;</code>. An error in the block names the line in
        the <code>.vue</code> file.
    </p>

    <h2 id="ssr">Server rendering</h2>
    <p>
        With <a href="/docs/server-rendering">server rendering</a> on, the page's first HTML has the Vue view rendered
        in it. The browser then hydrates it, taking over the elements that are there. Add the view to your render
        service, with the same plugins:
    </p>

    <x-docs.code src="vue-ssr.js" lang="js" />

    <ul>
        <li><strong>Code that needs the browser</strong> (<code>window</code>, <code>localStorage</code>, measuring an element) goes in <code>onMounted()</code>, as in any server-rendered Vue app.</li>
        <li><strong>On the server, a view only reads.</strong> It can't call methods or write properties while it renders.</li>
        <li><strong>A view that fails to render on the server</strong> is left to the browser, which renders it as it would without server rendering.</li>
    </ul>

    <h2 id="from-blade">Coming from Blade</h2>

    @php
        $equivalents = [
            ['`nitro:model="title"`', '`v-model="title"`'],
            ['`nitro:model.blur="title"`', '`v-model.lazy="title"`'],
            ['`nitro:click="addTag(\'vue\')"`', '`@click="addTag(\'vue\')"`'],
            ['`nitro:submit="save"`', '`@submit.prevent="save"`'],
            ['`nitro:loading` (`nitro:target="save"`)', '`v-if="save.processing"`'],
            ['`nitro:loading.delay`', '`v-if="save.slow"`'],
            ['`nitro:loading.attr="disabled"`', '`:disabled="save.processing"`'],
            ['`nitro:dirty`', '`v-if="unsaved.length"`'],
            ['`@error(\'title\') {{ $message }} @enderror`', '`{{ errors.title?.[0] }}`'],
            ['`nitro:model` on a file input', '`@change="upload(\'cover\', $event.target.files)"`'],
            ['`<a href="/posts" nitro:navigate>`', '`<a v-bind="link(\'/posts\')">`'],
            ['`$dispatch(\'saved\', $id)`', '`dispatch(\'saved\', id)`'],
            ['`$visit(\'/posts\')`', '`visit(\'/posts\')`'],
            ['`{{ $this->words }}`', '`{{ words }}`'],
        ];
    @endphp
    <x-docs.table :columns="['Blade', 'Vue']" :rows="$equivalents" />

    <h2 id="limits">Good to know</h2>
    <ul>
        <li><strong>The view's root</strong> is rendered inside the component's element, a <code>&lt;div&gt;</code> Nitro puts on the page. Style it from the inside.</li>
        <li><strong>Several Vue views on a page</strong> are separate Vue apps. Share state between them with Nitro's <a href="/docs/sharing-state">stores</a> or events, or with one Pinia.</li>
        <li><strong>TypeScript</strong>: <code>&lt;script setup lang="ts"&gt;</code> works as usual. What <code>useNitro()</code> returns isn't typed yet.</li>
        <li><strong>A visit</strong> to a page loads its Vue views' code before the page shows, so the page appears with them rendered, not filling in after it.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="book">How views in Vue, React, Solid and Svelte fit into Nitro, and when to choose one.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server">What a #[Server] method can take, return and check.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

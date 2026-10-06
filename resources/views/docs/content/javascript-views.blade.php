<x-docs.page
    lead="A component's view can be a Vue, React or Solid component instead of Blade. The PHP class is the same: its properties, its browser methods compiled from PHP, its #[Server] methods and their rules. Only the view changes, and it works with the component through the same names."
>
    <p>
        Blade is Fusion's own view engine: Fusion compiles it and renders it on the server and in the browser.
        A JavaScript view is built by your app's Vite, like any other Vue, React or Solid component, and the
        browser renders it. Use one when a view is best written in a framework: a rich editor, a chart, a library
        you already have. Components with different views sit side by side on one page.
    </p>

    <h2 id="setup">Setting it up</h2>
    <p>
        Add Fusion's Vite plugin and the plugin of each framework you use, then register each framework's views
        with Fusion. Views can live in <code>resources/views/vue</code> or <code>resources/js/vue</code> (and the
        same for <code>react</code> and <code>solid</code>); they load when a page shows them.
    </p>

    <x-docs.code src="js-views-setup.js" lang="js" />

    <p>
        The plugin gives you <code>nitro-fusion/vue</code>, <code>nitro-fusion/react</code> and
        <code>nitro-fusion/solid</code>, keeps a single copy of each framework, and leaves a <code>.vue</code>
        file's <code>&lt;php&gt;</code> block to Fusion.
    </p>

    <h2 id="class-and-view">A class and its view</h2>
    <p>
        The class names its view with <code>#[View(vue: 'post-editor')]</code>,
        <code>#[View(react: ...)]</code> or <code>#[View(solid: ...)]</code>. Everything else is the class
        you would write for Blade.
    </p>

    <x-docs.code src="js-views-component.php" file="app/Fusion/Components/PostEditor.php" runs="both" />

    <p>The view sees the component by its PHP names, in each framework's own way:</p>

    <x-docs.tabs>
        <x-docs.tab label="Vue">
            <x-docs.code src="js-views-post-editor.vue" lang="vue" bare />
        </x-docs.tab>
        <x-docs.tab label="React">
            <x-docs.code src="js-views-post-editor-react.jsx" lang="jsx" bare />
        </x-docs.tab>
        <x-docs.tab label="Solid">
            <x-docs.code src="js-views-post-editor-solid.jsx" lang="jsx" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <ul>
        <li><strong>Vue:</strong> the template uses the names bare, and <code>v-model</code> writes a property, deep into arrays too. In <code>&lt;script setup&gt;</code>, <code>useFusion()</code> gives the same names: properties and values as refs, and the functions.</li>
        <li><strong>React:</strong> the view gets the component as its props. Write a property with <code>set('title', value)</code> or <code>set('form.email', value)</code>. A component inside the view can call <code>useFusion()</code>.</li>
        <li><strong>Solid:</strong> the view gets the component as reactive props. Read them where you use them (<code>props.title</code>), as with any Solid props. Only what changed updates.</li>
    </ul>

    <x-docs.callout type="note" title="The same component, whatever its view">
        <p>
            <code>addTag()</code> runs in the browser in all three, compiled from the PHP. <code>save()</code> runs on
            the server, checks its rules there, and returns its value to the view. Fusion's browser tests run one
            component against its Blade, Vue, React and Solid views and expect the same results from each.
        </p>
    </x-docs.callout>

    <h2 id="what-the-view-gets">What the view gets</h2>

    @php
        $names = [
            ['Properties', '`title`, `tags`', 'By their PHP names, as plain arrays and values; models as objects with their attributes'],
            ['#[Computed] values', '`words`', 'Worked out again when what they read changes'],
            ['Browser methods', '`addTag(tag)`', 'Run in the browser, compiled from the PHP'],
            ['#[Server] methods', '`save()`', 'Return a promise of the method\'s value'],
            ['A call\'s status', '`save.processing` `save.slow` `save.failed` `save.error`', '`slow` once the call has taken 200ms; `failed` when the request itself failed'],
            ['Validation messages', '`errors.title?.[0]`', 'By field, as `$errors` has them'],
            ['Unsaved changes', '`unsaved`', 'The properties changed in the browser that the server hasn\'t seen yet'],
            ['Writing', '`set(\'form.email\', value)`', 'A property, or a key under one'],
            ['Events', '`dispatch(\'saved\', id)`', 'As `$dispatch` in Blade'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Name', '']" :rows="$names" />

    <p>
        When rules fail, the call isn't a failed call: the method answers with <code>null</code> and
        <code>errors</code> has the messages, as a Blade view shows them with <code>@@error</code>.
    </p>

    <h2 id="from-blade">Coming from Blade</h2>
    <p>Each <code>fusion:</code> attribute has a plain equivalent in the framework:</p>

    @php
        $equivalents = [
            ['`fusion:click="addTag(\'php\')"`', '`@click="addTag(\'php\')"`', '`onClick={() => addTag(\'php\')}`', '`onClick={() => props.addTag(\'php\')}`'],
            ['`fusion:model="title"`', '`v-model="title"`', '`value={title}` `onChange` with `set(\'title\', ...)`', '`value={props.title}` `onInput` with `props.set(...)`'],
            ['`fusion:submit="save"`', '`@submit.prevent="save()"`', '`onSubmit` with `preventDefault()`', '`onSubmit` with `preventDefault()`'],
            ['`fusion:loading`', '`v-if="save.processing"`', '`save.processing &&`', '`<Show when={props.save.processing}>`'],
            ['`fusion:loading.delay`', '`v-if="save.slow"`', '`save.slow &&`', '`<Show when={props.save.slow}>`'],
            ['`fusion:loading.attr="disabled"`', '`:disabled="save.processing"`', '`disabled={save.processing}`', '`disabled={props.save.processing}`'],
            ['`fusion:dirty`', '`v-if="unsaved.length"`', '`unsaved.length > 0 &&`', '`<Show when={props.unsaved.length}>`'],
            ['`@error(\'title\')`', '`errors.title?.[0]`', '`errors.title?.[0]`', '`props.errors.title?.[0]`'],
            ['`$dispatch(\'saved\')`', '`dispatch(\'saved\')`', '`dispatch(\'saved\')`', '`props.dispatch(\'saved\')`'],
        ];
    @endphp
    <x-docs.table :columns="['Blade', 'Vue', 'React', 'Solid']" :rows="$equivalents" />

    <h2 id="co-located">The PHP in the view's file</h2>
    <p>
        A component can live in one file. In a <code>.vue</code> file, put the class in a
        <code>&lt;php&gt;</code> block; in a <code>.jsx</code> or <code>.tsx</code> file, in a leading
        <code>/* &lt;php&gt; ... &lt;/php&gt; */</code> comment. Fusion makes it a class of its own, named after
        the view, and an error in it names the line in the view. <code>Component</code> and Fusion's attributes
        need no <code>use</code>.
    </p>

    <x-docs.tabs>
        <x-docs.tab label="invoice-lines.vue">
            <x-docs.code src="js-views-colocated.vue" lang="vue" bare />
        </x-docs.tab>
        <x-docs.tab label="invite-form.jsx">
            <x-docs.code src="js-views-colocated.jsx" lang="jsx" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <p>
        Place it by its view's name, as any component: <code>&lt;fusion:invoice-lines :invoice-id="$invoice-&gt;id" /&gt;</code>.
        The two ways mix freely: a class with its view beside it, or both in one file.
    </p>

    <h2 id="configuration">Configuration</h2>
    <p>
        <code>fusion.views</code> lists the engines: where each one's views are, their extensions, and the
        adapter that knows the framework's files. Add an entry for another framework, with an adapter class of
        your own (extending <code>Nitro\Fusion\View\ScriptEngine</code>) or none, and register its browser side
        with <code>Fusion.engine()</code> (see the JavaScript API).
    </p>

    <x-docs.callout type="note" title="Rendered in the browser">
        <p>
            The server renders a JavaScript view's element and its state, and the browser renders the view into it.
            Search engines and the first paint see the element, not the view. Server rendering for these views is
            planned; until then, use Blade for what must be in the first HTML.
        </p>
    </x-docs.callout>
</x-docs.page>

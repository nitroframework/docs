<x-docs.page
    lead="Your components need no JavaScript of your own. When the rest of your page does, such as analytics, an error tracker or a widget, the Nitro object and the runtime's browser events let it work with your components."
>
    <p>
        The runtime puts one object on the page, <code>window.Nitro</code>, and dispatches browser events as things
        happen. This page lists both. To add your own <code>nitro:</code> attributes or listen to every component,
        see <a href="/docs/extending">Extending Nitro</a>.
    </p>

    <h2 id="starting">Running code before components start</h2>
    <p>
        A script loaded before <code>@@nitroScripts</code> can't use <code>Nitro</code> yet. Listen for
        <code>nitro:starting</code> on the document instead. It fires once, after every script has loaded and before
        any component starts:
    </p>

    <x-docs.code src="js-starting.js" lang="js" />

    <h2 id="nitro">The Nitro object</h2>

    @php
        $api = [
            ['`Nitro.dispatch(event, params)`', 'Sends an event to every `#[On]` method that listens for it, and to the window, as `$this->dispatch()` does. `params` is a list'],
            ['`Nitro.visit(url)`', 'Goes to a page the way a `nitro:navigate` link does, without reloading'],
            ['`Nitro.components()`', 'The components on the page'],
            ['`Nitro.find(id)`', 'One component, by its `nitro:id`, or `null`'],
            ['`Nitro.directive(name, fn)`', 'Registers your own `nitro:` attribute'],
            ['`Nitro.use(plugin)`', 'Adds a plugin that runs around every component'],
            ['`Nitro.engine(name, { load, mount })`', 'Adds a view engine: components whose view is written for it. Vue, React, Solid and Svelte have theirs; see "A view engine of your own" below'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Does']" :rows="$api" />

    <p>
        <a href="/docs/extending#registering">Registering a directive</a> and
        <a href="/docs/extending#plugins">Writing plugins</a> cover the last two.
    </p>

    <x-docs.code src="js-nitro.js" lang="js" />

    <h3 id="components">A component</h3>
    <p>What <code>Nitro.components()</code> and <code>Nitro.find()</code> return has these members:</p>

    @php
        $component = [
            ['`id`', 'Its id, the element\'s `nitro:id`'],
            ['`name`', 'Its name, such as `counter` or `pages::orders`. An obfuscated build uses short aliases instead'],
            ['`el`', 'Its root element'],
            ['`dispatch(event, params)`', 'Sends an event from it, as its `$this->dispatch()` does'],
            ['`unsaved(paths)`', 'The properties (or paths) changed in the browser that the server hasn\'t seen yet, as `nitro:dirty` shows them. Without `paths`, all of them'],
        ];
    @endphp
    <x-docs.table :columns="['Member', 'What it is']" :rows="$component" />

    <h2 id="events">Listening for events</h2>
    <p>The runtime dispatches these events on the window. Each one carries its details in <code>event.detail</code>:</p>

    @php
        $events = [
            ['`nitro:request`', '`component`, `method`', 'A `#[Server]` call starts'],
            ['`nitro:response`', '`component`, `method`, `status`', 'Its answer arrives'],
            ['`nitro:error`', '`component`, `message`, and `status` and `body` for a failed request', 'Something failed: a call, a render, a handler'],
            ['`nitro:expired`', '`component`, `status`', 'The session or CSRF token expired (419). Nitro reloads the page, unless you call `preventDefault()`'],
            ['`nitro:navigating`', '`url`', 'A visit starts'],
            ['`nitro:navigated`', '`url`', 'A visit has shown the new page'],
            ['`nitro:flash`', '`flash`', 'Flash data arrived, as `Nitro::flash()` sent it'],
            ['Your own events', '`params`, `component`', 'A component called `$this->dispatch()` without `->to()` or `->self()`'],
        ];
    @endphp
    <x-docs.table :columns="['Event', 'Detail', 'When']" :rows="$events" />

    <x-docs.code src="js-events.js" lang="js" />

    <h3 id="upload-events">Upload events</h3>
    <p>
        A file input with <code>nitro:model</code> dispatches its own events, which bubble up from the input:
        <code>nitro-upload-start</code>, <code>nitro-upload-progress</code> (with <code>progress</code>, from 0 to
        100), <code>nitro-upload-finish</code> and <code>nitro-upload-error</code> (with <code>status</code> and
        <code>message</code>).
    </p>

    <x-docs.code src="js-upload-events.js" lang="js" />

    <h2 id="engines">A view engine of your own</h2>
    <p>
        Vue, React, Solid and Svelte views run on engines Nitro provides. For anything else, register your own: a
        charting library, a map, a canvas game, a framework Nitro has no adapter for. The component keeps its
        PHP class as always. Only its view is yours to render.
    </p>

    <x-docs.steps>
        <x-docs.step title="Name the engine in the config">
            <p>An entry in <code>nitro.views</code>: where its views are and their extensions. Without an <code>adapter</code>, its views hold no PHP.</p>
            <x-docs.code src="js-engine-config.php" bare />
        </x-docs.step>
        <x-docs.step title="Name the view on the class">
            <x-docs.code src="js-engine-component.php" bare />
        </x-docs.step>
        <x-docs.step title="Register the engine before components start">
            <p><code>load(view)</code> gives the view's module, by its name. <code>mount(module, el, handle)</code> renders it in <code>el</code>, and returns what the component tells it as it changes.</p>
            <x-docs.code src="js-engine-register.js" lang="js" bare />
        </x-docs.step>
    </x-docs.steps>

    <x-docs.code src="js-engine-view.js" lang="js" file="resources/js/charts/revenue.js" />

    <p>
        <code>update(names)</code> is called with the names of what changed: the properties, <code>"$errors"</code> for
        the validation messages, <code>"$unsaved"</code> when the server has taken the changes, or <code>"*"</code> for
        everything. <code>unmount()</code> is called when the component leaves the page.
    </p>

    <h3 id="handle">The handle</h3>
    <p>A view reads and changes its component through the handle, by the PHP's names, in plain JavaScript values:</p>

    @php
        $handle = [
            ['`get(path)`', 'A property\'s value, a key under it (`"form.email"`), or a `#[Computed]` value'],
            ['`set(path, value)`', 'Writes a property, or a key under it, as `nitro:model` does'],
            ['`watch(path, fn)`', 'Calls `fn(value)` whenever the value changes from anywhere but this handle\'s own `set()`; returns a function that stops watching'],
            ['`call(method, ...args)`', 'Runs a method. A browser method returns its value; a `#[Server]` one, a promise of it'],
            ['`errors()`', 'The validation messages, by field'],
            ['`unsaved()`', 'The properties changed here that the server hasn\'t seen yet'],
            ['`dispatch(event, ...params)`', 'Sends an event, as `$this->dispatch()` does'],
            ['`properties`, `methods`, `server`, `computed`', 'The names'],
            ['`id`, `component`', 'The component\'s id, and the component itself, as `Nitro.find()` gives it'],
        ];
    @endphp
    <x-docs.table :columns="['Member', 'Does']" :rows="$handle" />

    <p>
        With server rendering on, an engine of your own still works: the render service skips it, and its views
        render in the browser.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/extending" title="Extending Nitro" icon="bolt">Add your own nitro: attributes, plugins and server features.</x-docs.card>
        <x-docs.card href="/docs/events" title="Events" icon="book">Send events between components with $this->dispatch() and #[On].</x-docs.card>
    </x-docs.cards>
</x-docs.page>

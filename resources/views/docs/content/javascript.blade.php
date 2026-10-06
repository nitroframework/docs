<x-docs.page
    lead="Your components need no JavaScript of your own. When the rest of your page does, such as analytics, an error tracker or a widget, the Fusion object and the runtime's browser events let it work with your components."
>
    <p>
        The runtime puts one object on the page, <code>window.Fusion</code>, and dispatches browser events as things
        happen. This page lists both. To add your own <code>fusion:</code> attributes or hook into every component,
        see <a href="/docs/extending">Extending Fusion</a>.
    </p>

    <h2 id="starting">Running code before components start</h2>
    <p>
        A script loaded before <code>@@fusionScripts</code> can't use <code>Fusion</code> yet. Listen for
        <code>fusion:starting</code> on the document instead. It fires once, after every script has loaded and before
        any component starts:
    </p>

    <x-docs.code src="js-starting.js" lang="js" />

    <h2 id="fusion">The Fusion object</h2>

    @php
        $api = [
            ['`Fusion.dispatch(event, params)`', 'Sends an event to every `#[On]` method that listens for it, and to the window, as `$this->dispatch()` does. `params` is a list'],
            ['`Fusion.visit(url)`', 'Goes to a page the way a `fusion:navigate` link does, without reloading'],
            ['`Fusion.components()`', 'The components on the page'],
            ['`Fusion.find(id)`', 'One component, by its `fusion:id`, or `null`'],
            ['`Fusion.directive(name, fn)`', 'Registers your own `fusion:` attribute'],
            ['`Fusion.use(plugin)`', 'Adds a plugin that runs around every component'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Does']" :rows="$api" />

    <p>
        <a href="/docs/extending#registering">Registering a directive</a> and
        <a href="/docs/extending#plugins">Writing plugins</a> cover the last two.
    </p>

    <x-docs.code src="js-fusion.js" lang="js" />

    <h3 id="components">A component</h3>
    <p>What <code>Fusion.components()</code> and <code>Fusion.find()</code> return has these members:</p>

    @php
        $component = [
            ['`id`', 'Its id, the element\'s `fusion:id`'],
            ['`name`', 'Its name, such as `counter` or `pages::orders`. An obfuscated build uses short aliases instead'],
            ['`el`', 'Its root element'],
            ['`dispatch(event, params)`', 'Sends an event from it, as its `$this->dispatch()` does'],
            ['`unsaved(paths)`', 'The properties (or paths) changed in the browser that the server hasn\'t seen yet, as `fusion:dirty` shows them. Without `paths`, all of them'],
        ];
    @endphp
    <x-docs.table :columns="['Member', 'What it is']" :rows="$component" />

    <h2 id="events">Listening for events</h2>
    <p>The runtime dispatches these events on the window. Each one carries its details in <code>event.detail</code>:</p>

    @php
        $events = [
            ['`fusion:request`', '`component`, `method`', 'A `#[Server]` call starts'],
            ['`fusion:response`', '`component`, `method`, `status`', 'Its answer arrives'],
            ['`fusion:error`', '`component`, `message`, and `status` and `body` for a failed request', 'Something failed: a call, a render, a handler'],
            ['`fusion:expired`', '`component`, `status`', 'The session or CSRF token expired (419). Fusion reloads the page, unless you call `preventDefault()`'],
            ['`fusion:navigating`', '`url`', 'A visit starts'],
            ['`fusion:navigated`', '`url`', 'A visit has shown the new page'],
            ['`fusion:flash`', '`flash`', 'Flash data arrived, as `Fusion::flash()` sent it'],
            ['Your own events', '`params`, `component`', 'A component called `$this->dispatch()` without `->to()` or `->self()`'],
        ];
    @endphp
    <x-docs.table :columns="['Event', 'Detail', 'When']" :rows="$events" />

    <x-docs.code src="js-events.js" lang="js" />

    <h3 id="upload-events">Upload events</h3>
    <p>
        A file input with <code>fusion:model</code> dispatches its own events, which bubble up from the input:
        <code>fusion-upload-start</code>, <code>fusion-upload-progress</code> (with <code>progress</code>, from 0 to
        100), <code>fusion-upload-finish</code> and <code>fusion-upload-error</code> (with <code>status</code> and
        <code>message</code>).
    </p>

    <x-docs.code src="js-upload-events.js" lang="js" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/extending" title="Extending Fusion" icon="bolt">Add your own fusion: attributes, plugins and server features.</x-docs.card>
        <x-docs.card href="/docs/events" title="Events" icon="book">Send events between components with $this->dispatch() and #[On].</x-docs.card>
    </x-docs.cards>
</x-docs.page>

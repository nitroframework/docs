<x-docs.page
    lead="Hooks let your own JavaScript take part in what Nitro does in the browser: a request about to be sent, a visit finishing, a component leaving the page. Listen to the moments you need, add a header, count a page view, or stop a visit when there are unsaved changes."
>
    <p>
        A component's own hooks, such as <code>mounted()</code> and <code>updated()</code>, are about that one
        component (see <a nitro:navigate href="/docs/lifecycle">Lifecycle</a>). The hooks on this page are the
        runtime's: they run for every component, request and visit on the page, which is what analytics, error
        trackers, progress bars and your own plugins need.
    </p>

    <h2 id="listening">Listening</h2>
    <p>
        <code>Nitro.hook(name, listener)</code> calls the listener each time the moment comes, and returns a function
        that removes it:
    </p>

    <x-docs.code src="hooks-listen.js" lang="js" />

    <h2 id="hooks">The hooks</h2>

    <h3 id="the-page">The page</h3>
    @php
        $page = [
            ['`init`', 'Once, before the page\'s components start. Register directives, view engines and plugins here', '`{ Nitro }`'],
            ['`initialized`', 'Once, when the first page\'s components are all live', '`{ Nitro }`'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$page" />

    <h3 id="components">Components</h3>
    @php
        $components = [
            ['`component.init`', 'A component is made, before its first render', 'the component'],
            ['`component.initialized`', 'It has started in the page: its first render is done', 'the component'],
            ['`component.rendered`', 'After each of its renders', 'the component'],
            ['`component.destroyed`', 'It has left the page, whatever took it out: its view, a visit, or another script', 'the component'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$components" />
    <p>
        A component is <code>{ name, el, dispatch(event, ...params) }</code>. A listener of
        <code>component.initialized</code> added after the page started hears the components already there too.
    </p>

    <h3 id="stores">Stores</h3>
    @php
        $stores = [
            ['`store.initialized`', 'A store is made in this tab', 'the store'],
            ['`store.updated`', 'Its values changed: here, from the server, or from another tab with `#[Sync]`', 'the store'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$stores" />
    <p>
        A store is <code>{ name, persist, sync, get(property), values(), set(property, value), onChange(listener) }</code>,
        its values as the server sends them. <code>set()</code> is a change made in the browser, which the server checks
        on the next call.
    </p>

    <h3 id="requests">Requests</h3>
    @php
        $requests = [
            ['`beforeRequest`', 'Before a request goes: a `#[Server]` call (`kind` is `call`), a partial reload (`reload`), an upload (`upload`)', '`{ component, method, kind, headers }`. Add to `headers` to send your own; Nitro\'s can\'t be changed'],
            ['`afterRequest`', 'Its answer arrived, or it was stopped', '`{ component, method, kind, status, cancelled, ms, bytes }`, and in development `serverMs` and `dbMs`. `status` is 0 when no answer came'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$requests" />

    <h3 id="navigation">Navigation</h3>
    @php
        $navigation = [
            ['`beforeNavigate`', 'A `nitro:navigate` visit starts, from a link, `Nitro.visit()`, or back and forward (`history`)', '`{ url, cancelable, history }`'],
            ['`afterNavigate`', 'The visit is over: its page is shown, or it was stopped, or a newer visit replaced it before its page came (`cancelled`)', '`{ url, cancelled, history }`'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$navigation" />

    <h3 id="messages">Messages</h3>
    @php
        $messages = [
            ['`flash`', 'Flash data arrived for the page, as `Nitro::flash()` sent it', '`{ flash }`'],
            ['`error`', 'Something failed in the browser: a call, a render, a handler', '`{ component, message }`, and `status` and `body` for a failed request'],
            ['`expired`', 'The session or the component\'s state expired (419). Nitro reloads the page unless a listener calls `preventDefault()`', '`{ component, status }`'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'When', 'The listener gets']" :rows="$messages" />

    <h2 id="stopping">Stopping a request or a visit</h2>
    <p>
        A <code>beforeRequest</code> or <code>beforeNavigate</code> listener can call <code>preventDefault()</code> to
        stop what is about to happen. A stopped <code>#[Server]</code> call sends nothing and resolves with
        <code>null</code>; what changed in the browser stays, and goes with the next call. A stopped upload fires
        <code>nitro-upload-cancel</code> on its input.
    </p>

    <x-docs.code src="hooks-unsaved.js" lang="js" />

    <p>
        Back and forward can't be stopped: by the time the visit starts, the browser has already changed the address.
        Their <code>beforeNavigate</code> has <code>cancelable: false</code>, and <code>preventDefault()</code> does
        nothing there.
    </p>

    <x-docs.code src="hooks-offline.js" lang="js" />

    <ul>
        <li><strong>Every before has its after.</strong> A stopped request or visit still gets its <code>afterRequest</code> or <code>afterNavigate</code>, with <code>cancelled: true</code>, so a counter of what's in flight, such as a progress bar, stays right.</li>
        <li><strong>The order.</strong> Listeners run in the order they were added. One added earlier hears a moment even when a later one stops it, which is why the after always comes.</li>
    </ul>

    <h2 id="before-nitro">Before Nitro is on the page</h2>
    <p>
        <code>Nitro.hook()</code> needs <code>Nitro</code>. A script that loads before <code>@@nitroScripts</code>, such
        as a module in the <code>&lt;head&gt;</code>, waits for <code>nitro:init</code> on the document instead, which
        comes with <code>Nitro</code> just before any component starts. See
        <a nitro:navigate href="/docs/javascript#starting">Running code before components start</a>.
    </p>

    <h2 id="window-events">Window events</h2>
    <p>
        Most hooks also dispatch an event, with the same details in <code>event.detail</code> and the component by
        its name. It suits code that only listens, such as a widget that knows nothing of Nitro. A stoppable hook's
        event can be stopped with <code>event.preventDefault()</code> as well.
    </p>

    @php
        $events = [
            ['`nitro:init`, `nitro:initialized`', 'On the document', '`nitro:starting` for `nitro:init`'],
            ['`nitro:before-request`, `nitro:after-request`', 'Every request', '`nitro:request` and `nitro:response`, for `#[Server]` calls'],
            ['`nitro:before-navigate`, `nitro:after-navigate`', 'Every visit', '`nitro:navigating` and `nitro:navigated`'],
            ['`nitro:flash`, `nitro:error`, `nitro:expired`', '', ''],
        ];
    @endphp
    <x-docs.table :columns="['Events', 'For', 'Earlier names, still sent']" :rows="$events" />

    <p>
        The earlier names are still sent through 2.x, so code written for them keeps working. They can't be stopped,
        as they never could.
    </p>

    <h2 id="plugins">In a plugin</h2>
    <p>
        A plugin's <code>on(name, listener)</code> is <code>Nitro.hook()</code>, so a plugin listens to the same hooks.
        The names plugins used before, <code>component</code>, <code>render</code>, <code>store</code>,
        <code>request</code> and <code>response</code>, still work. See
        <a nitro:navigate href="/docs/extending#plugins">Writing plugins</a>.
    </p>

    <h2 id="errors">When a listener fails</h2>
    <p>
        A listener that throws is reported, as the <code>error</code> hook and in the console, and the other
        listeners still run. A listener of <code>error</code> itself that throws only goes to the console, so a
        broken error tracker can't loop.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/javascript" title="JavaScript API" icon="code">The Nitro object, upload events and view engines of your own.</x-docs.card>
        <x-docs.card href="/docs/extending" title="Extending Nitro" icon="bolt">Plugins, your own nitro: attributes, and features on the server.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="Events let components tell each other that something happened. A component dispatches an event, from the browser or from the server, and every component listening with a matching #[On] runs its method."
>
    <p>
        Use events for news, not for keeping state. An event might carry a message to show, a list to refresh or a
        sound to play. A component dispatches an event with <code>$this-&gt;dispatch()</code>, or with
        <code>$dispatch()</code> from its view. Components that listen with <code>#[On]</code> then run their
        method, with the event's parameters. If several components need to read the same state, use a
        <a nitro:navigate href="/docs/sharing-state">store</a> instead.
    </p>

    <x-docs.example component="notifier" title="Two ways to say something" source="#the-components" />
    <x-docs.example component="toaster" title="The toaster that listens" source="#the-components" />

    <p>
        The first button dispatches <code>notify</code> from its view, in the browser. The second button calls a
        <code>#[Server]</code> method that dispatches the event on the server. That event arrives with the
        server's answer and reaches the same listener.
    </p>

    <h2 id="the-components">The components</h2>
    <x-docs.pair class="app/Nitro/Components/Notifier.php" view="resources/views/nitro/components/notifier.blade.php" component="notifier" />
    <x-docs.pair class="app/Nitro/Components/Toaster.php" view="resources/views/nitro/components/toaster.blade.php" component="toaster" />

    <h2 id="dispatching">Dispatching and listening for events</h2>
    <x-docs.code src="events-dispatch.php" highlight="5" />

    <ul>
        <li><strong>Every listener</strong> on the page hears an event by default. Use <code>-&gt;to(Toaster::class)</code> to reach only the components of that class, or <code>-&gt;self()</code> to reach only the component that dispatches it.</li>
        <li><strong>Parameters</strong> are passed to the listener in order, as arguments.</li>
        <li><strong>A listener</strong> runs in the browser, or on the server if it is a <code>#[Server]</code> method.</li>
        <li><strong>Events dispatched on the server</strong> by a <code>#[Server]</code> method arrive with its answer, and are dispatched in the browser at that point.</li>
    </ul>

    <h2 id="in-a-view">Dispatching from a view</h2>
    <x-docs.code src="events-view.blade.php" lang="blade" />

    <p>
        <code>$parent-&gt;save()</code> calls a method of the component whose view placed this one. This lets a child
        ask its parent to act, without an event.
    </p>

    <h2 id="window">Listening on the window</h2>
    <p>An event that you don't narrow with <code>-&gt;to()</code> or <code>-&gt;self()</code> is also a DOM event on the window, so your own scripts can listen for it:</p>

    <x-docs.code src="events-window.js" lang="js" />

    <h2 id="broadcasting">Listening to broadcasts</h2>
    <p>
        <code>#[On('echo:...')]</code> listens to Laravel broadcasting through your application's Laravel Echo
        (<code>window.Echo</code>, with Reverb or Pusher). The component subscribes when it appears, and it stops
        listening when it leaves the page.
    </p>

    <x-docs.code src="events-broadcast.php" />

    <ul>
        <li>A <code>{property}</code> in a channel name reads the component's state. It must name a public property, and the build tells you if it doesn't.</li>
        <li>For an event with a custom name (set with <code>broadcastAs()</code>), write the name with a leading dot, as in <code>echo:orders,.order.placed</code>.</li>
        <li>Laravel authorizes private and presence channels, just as it does for any Echo listener.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/sharing-state" title="Sharing state" icon="book">Use a store when several components need the same state.</x-docs.card>
        <x-docs.card href="/docs/transitions" title="Transitions" icon="bolt">Animate elements as they enter, leave and move.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

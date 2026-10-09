<x-docs.page
    lead="When a component fails, in production, it shows a fallback in its place and the rest of the page works on. The error goes to Laravel's exception handler. In development, you see the error itself."
>
    <p>
        A page is made of many components, and one of them failing shouldn't take the others down. A bank feed
        that is down, a view with a bug, a <code>#[Server]</code> call that throws: in production, Nitro shows that
        component's fallback, reports the error as Laravel reports any other, and leaves every other component
        working. You don't have to do anything for this. A component without a fallback of its own shows a short
        message with a link that loads the page again.
    </p>

    <h2 id="fallback">A component's own fallback</h2>
    <p>
        Give a component a <code>fallback()</code> method to choose what shows in its place. It runs on the server,
        and receives the exception:
    </p>

    <x-docs.code src="fallback-component.php" file="app/Nitro/Components/BankBalance.php" highlight="23" runs="server" />

    <ul>
        <li><strong>Optional.</strong> Without <code>fallback()</code>, the component gets your app's fallback view, or Nitro's message.</li>
        <li><strong>Its parameter is optional too.</strong> Take <code>Throwable $exception</code> when the fallback depends on what went wrong; leave it out when it doesn't.</li>
        <li><strong>It shows the visitor something safe.</strong> Never put the exception's message in the fallback: it can hold paths, queries or keys. The message goes to your logs.</li>
        <li><strong>If it throws,</strong> that error is reported too, and the app's fallback view or Nitro's message shows instead.</li>
    </ul>

    <p><code>fallback()</code> can return a view, an <code>Htmlable</code>, or text:</p>

    <x-docs.code src="fallback-returns.php" runs="server" />

    <h2 id="default">Your app's fallback</h2>
    <p>
        For the components without <code>fallback()</code>, name a view in <code>config/nitro.php</code>. Without
        one, Nitro shows this, which you can style with <code>.nitro-fallback</code>:
    </p>

    <x-docs.code src="fallback-default.html" lang="html" />
    <x-docs.code src="fallback-config.php" />

    <h2 id="where">Where a failure is caught</h2>

    @php
        $where = [
            ['Its `mount()` or its view, on the server: the first page, a visit, a child a `#[Server]` call creates', 'Its `fallback()`, else the app\'s', 'The fallback is in the page\'s HTML in the component\'s place. The page and its other components render as usual'],
            ['A `#[Server]` method throws', 'Its `fallback()`, else the app\'s', 'The call answers 500 with the fallback, and the browser shows it in the component\'s place'],
            ['Its view, rendering in the browser', 'The app\'s (`fallback()` runs on the server, so it isn\'t asked)', 'The browser shows it in the component\'s place, and reports the error in the console'],
        ];
    @endphp
    <x-docs.table :columns="['When it fails', 'What shows', '']" :rows="$where" />

    <p>
        A component showing its fallback is finished: it doesn't render again or take calls. The others carry on.
        Nitro's message, and a link in your own fallback with <code>href=""</code>, load the page again, which
        starts the component afresh.
    </p>

    <h2 id="not-fallbacks">What isn't a fallback</h2>
    <ul>
        <li><strong>The page itself.</strong> A page whose own <code>mount()</code> or view throws has nothing around it to keep working, so Laravel answers with its error page, as it does for a controller. Fallbacks are for the components inside a page or a plain Blade view.</li>
        <li><strong>Laravel's answers.</strong> <code>abort(403)</code>, a failed <code>Gate::authorize()</code>, <code>findOrFail()</code> finding nothing, a guest where a user is needed, a redirect thrown with <code>HttpResponseException</code>, and every other exception Laravel's handler turns into a response, are answers, not failures. The visitor gets them as Laravel sends them, from a component in a page as from a controller, with fallbacks on or off.</li>
        <li><strong>Validation.</strong> A rule that fails puts its messages in <code>$errors</code>, as always.</li>
        <li><strong>An error <code>exception()</code> handles.</strong> A <code>#[Server]</code> method's error goes to the component's <code>exception()</code> hook first. When the hook handles it, the call answers normally, with the state as the hook left it. See <a nitro:navigate href="/docs/lifecycle#exception">Lifecycle</a>.</li>
    </ul>

    <x-docs.callout type="tip" title="exception() or fallback()?">
        <p>Use <code>exception()</code> when the component can carry on, such as "The CRM isn't answering, try again in a minute" beside a form that keeps what was typed. Use <code>fallback()</code> when it can't, such as a widget whose data never loaded.</p>
    </x-docs.callout>

    <h2 id="development">In development</h2>
    <p>
        Fallbacks are off while <code>APP_DEBUG</code> is on, so you see the error itself: Laravel's error page for
        a failure on the server, and the error in the browser's console for a call or a render in the browser. A
        component whose call failed keeps its last state.
    </p>
    <p>
        To try your fallbacks locally, set <code>NITRO_FALLBACKS=true</code> in <code>.env</code>. To turn them
        off in production, set it to <code>false</code>.
    </p>

    <h2 id="reporting">Reporting</h2>
    <p>
        Every failure that becomes a fallback goes to Laravel's exception handler, so your logs, Sentry, Flare or
        Nightwatch see it as they see any other error, with its stack trace. In the browser, Nitro dispatches
        <code>nitro:error</code> on the window for each failure there, with the component and the message:
    </p>

    <x-docs.code src="fallback-error-event.js" lang="js" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/lifecycle" title="Lifecycle" icon="cycle" runs="both">Every hook, exception() included, and where each runs.</x-docs.card>
        <x-docs.card href="/docs/javascript" title="JavaScript API" icon="code">nitro:error and the runtime's other events.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

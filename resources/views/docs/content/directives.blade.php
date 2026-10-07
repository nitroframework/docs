<x-docs.page
    lead="Directives are fusion: attributes that connect a view to its component. Use them to call methods on events, bind inputs to properties, and add behaviours such as loading states, polling and confirmations."
>
    <p>
        Every directive is an HTML attribute that starts with <code>fusion:</code>. Its value is a method name, a
        method call with arguments, or one of Fusion's built-in actions. You don't need to write any JavaScript.
    </p>

    <x-docs.example component="shortcuts" title="Keys, clicks outside and polling" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        Pressing Enter calls <code>add()</code>, and pressing Escape clears the field with <code>$set</code>. The
        menu opens with <code>$toggle</code> and closes when you click outside it. <code>fusion:poll.1s</code>
        calls <code>tick()</code> every second. All of this runs in the browser.
    </p>

    <x-docs.pair class="app/Fusion/Components/Shortcuts.php" view="resources/views/fusion/components/shortcuts.blade.php" component="shortcuts" />

    <h2 id="events">Handling events</h2>
    <p>
        You can listen for any DOM event, such as <code>fusion:click</code>, <code>fusion:submit</code>,
        <code>fusion:input</code> or <code>fusion:keydown</code>. The value is a method name, a method call such
        as <code>remove($index)</code>, or an action.
    </p>

    <x-docs.code src="directive-events.blade.php" lang="blade" />

    <p>
        <code>fusion:submit</code> always stops the browser from posting the form and reloading the page, so you
        don't need <code>.prevent</code> on it.
    </p>

    <p>Modifiers change how an event is handled:</p>

    @php
        $modifiers = [
            ['`.prevent`, `.stop`', 'Call `preventDefault()` or `stopPropagation()`'],
            ['`.self`', 'Only when the event starts on the element itself'],
            ['`.once`', 'Only the first time'],
            ['`.window`, `.document`', 'Listen on the window or the document'],
            ['`.outside`', 'A click outside the element'],
            ['`.passive`', 'A passive listener: the handler cannot call `preventDefault()`, so scrolling and touch stay smooth'],
            ['`.capture`', 'Handle the event on its way down, before the elements inside the element see it'],
            ['`.enter`, `.escape`, ...', 'A specific key'],
            ['`.debounce.300ms`, `.throttle.1s`', 'Limit how often the handler runs'],
        ];
    @endphp
    <x-docs.table :columns="['Modifier', 'Does']" :rows="$modifiers" />

    <h2 id="actions">Using actions</h2>
    <p>Actions do common things without a method of your own:</p>

    @php
        $actions = [
            ['`$set(\'prop\', value)`', 'Set a property'],
            ['`$toggle(\'prop\')`', 'Flip a boolean'],
            ['`$refresh`', 'Render again (with a `#[Server]` round trip when the component has server methods)'],
            ['`$dispatch(\'event\', ...)`', 'Dispatch an event; `$dispatchTo(\'name\', \'event\', ...)` and `$dispatchSelf(\'event\', ...)` narrow it'],
            ['`$parent->save()`', 'Call the parent component\'s method'],
            ['`$reload(\'prop\', ...)`', 'Reload page properties from the page\'s route (pages only)'],
            ['`$loadMore(\'prop\')`', 'Load the next page of a scroll property (pages only)'],
            ['`$visit(url)`', 'Go to another page, as a `fusion:navigate` link does'],
        ];
    @endphp
    <x-docs.table :columns="['Action', 'Does']" :rows="$actions" />

    <h2 id="binding">Binding inputs</h2>
    <p>
        <code>fusion:model</code> keeps an input and a property in sync, in both directions.
    </p>

    <x-docs.code src="directive-model.blade.php" lang="blade" />

    <p>
        You can add the <code>.blur</code>, <code>.debounce.300ms</code>, <code>.number</code>,
        <code>.trim</code> and <code>.boolean</code> modifiers. Each change runs the component's
        <code>updated*()</code> hooks (see <a fusion:navigate href="/docs/methods#updated-hooks">Methods</a>).
    </p>

    <h2 id="attributes">Other attributes</h2>
    <p>Fusion has these other attributes:</p>

    @php
        $fusionAttributes = [
            ['`fusion:model="email"`', 'Two-way binding (above)'],
            ['`fusion:loading`', 'Shown while a `#[Server]` call runs. `.remove`, `.class="..."`, `.class.remove="..."`, `.attr="disabled"`; `.delay` (`.delay.500ms`) waits first; `fusion:target="save,delete"` limits it to those methods'],
            ['`fusion:dirty`', 'Shown while the page has changes the server hasn\'t seen. The same forms as `fusion:loading`; `fusion:target="title"` limits it to those properties'],
            ['`fusion:key`', 'Keeps an element\'s identity in a list'],
            ['`fusion:navigate`', 'A link to another page, rendered without a reload (see Navigation)'],
            ['`fusion:current="active"`', 'A class while the link points at the current page; `.exact` for the same path only'],
            ['`fusion:ignore`', 'Leaves the element as it is when the component renders again'],
            ['`fusion:confirm="Delete it?"`', 'Asks before the element\'s handlers run'],
            ['`fusion:poll.30s="refresh"`', 'Calls a method every interval (2.5s by default)'],
            ['`fusion:init="load"`', 'Calls a method once, when the element appears'],
            ['`fusion:visible="loadMore"`', 'Calls a method when the element comes into view'],
            ['`fusion:ref="chart"`', 'The element, as `$refs.chart` in `$this->js()` and for the browser APIs'],
            ['`fusion:transition`', 'Animates the element as it enters and leaves (see Transitions)'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'Does']" :rows="$fusionAttributes" />

    <h3 id="confirm">Asking for confirmation</h3>
    <p>
        <code>fusion:confirm</code> asks the visitor before the element's handlers run. With <code>.prompt</code>,
        the visitor must type a word to confirm, which is the word after the last <code>|</code>:
    </p>

    <x-docs.code src="directive-confirm.blade.php" lang="blade" />

    <h3 id="polling">Polling and reacting to visibility</h3>
    <p>These attributes call a method on a timer, when an element appears, or when it comes into view:</p>

    <x-docs.code src="directive-poll.blade.php" lang="blade" />

    <ul>
        <li>A bare <code>fusion:poll</code> refreshes the component. Polling pauses while the tab is hidden. Add <code>.keep-alive</code> to keep it going, or <code>.visible</code> to poll only while the element is on screen.</li>
        <li>Add <code>.once</code> to <code>fusion:visible</code> to call the method only the first time. While the element stays in view, the method is called again after each call that changed something, so a "load more" row keeps loading until the screen is full.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs, validate them, and show the errors.</x-docs.card>
        <x-docs.card href="/docs/navigation" title="Navigation" icon="arrow">Move between pages without a full reload.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

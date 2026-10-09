<x-docs.page
    lead="Directives are nitro: attributes that connect a view to its component. Use them to call methods on events, bind inputs to properties, and add behaviours such as loading states, polling and confirmations."
>
    <p>
        Every directive is an HTML attribute that starts with <code>nitro:</code>. Its value is a method name, a
        method call with arguments, or one of Nitro's built-in actions. You don't need to write any JavaScript.
    </p>

    <x-docs.example component="shortcuts" title="Keys, clicks outside and polling" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        Pressing Enter calls <code>add()</code>, and pressing Escape clears the field with <code>$set</code>. The
        menu opens with <code>$toggle</code> and closes when you click outside it. <code>nitro:poll.1s</code>
        calls <code>tick()</code> every second. All of this runs in the browser.
    </p>

    <x-docs.pair class="app/Nitro/Components/Shortcuts.php" view="resources/views/nitro/components/shortcuts.blade.php" component="shortcuts" />

    <h2 id="events">Handling events</h2>
    <p>
        You can listen for any DOM event, such as <code>nitro:click</code>, <code>nitro:submit</code>,
        <code>nitro:input</code> or <code>nitro:keydown</code>. The value is a method name, a method call such
        as <code>remove($index)</code>, or an action.
    </p>

    <x-docs.code src="directive-events.blade.php" lang="blade" />

    <p>
        <code>nitro:submit</code> always stops the browser from posting the form and reloading the page, so you
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
            ['`.enter`, `.escape`, `.space`, ...', 'Only for that key (see Keys below), or a letter or digit: `.k`, `.1`'],
            ['`.shift`, `.ctrl`, `.alt`, `.meta`', 'Only while that key is held, on a key press or a click'],
            ['`.debounce.300ms`', 'Run the handler once the events stop for that long (250ms without a time)'],
            ['`.throttle.1s`', 'Run it at most once in that time (250ms without a time)'],
        ];
    @endphp
    <x-docs.table :columns="['Modifier', 'Does']" :rows="$modifiers" />

    <h3 id="keys">Keys</h3>
    <p>
        On <code>nitro:keydown</code> and <code>nitro:keyup</code>, a key modifier runs the handler only for that key.
        Give several, and any of them runs it. A modifier key (<code>.shift</code>, <code>.ctrl</code>,
        <code>.alt</code>, <code>.meta</code>) must be held as well, and it works on clicks too:
    </p>

    <x-docs.code src="directive-keys.blade.php" lang="blade" />

    @php
        $keys = [
            ['`.enter`', 'Enter'],
            ['`.escape`, `.esc`', 'Escape'],
            ['`.space`', 'The space bar'],
            ['`.tab`', 'Tab'],
            ['`.up`, `.down`, `.left`, `.right`', 'The arrow keys'],
            ['`.delete`, `.backspace`', 'Delete and Backspace'],
            ['`.a` to `.z`, `.0` to `.9`', 'That letter or digit: `.k` is K, `.1` is 1'],
            ['`.shift`, `.ctrl`, `.alt`, `.meta`', 'Held down: Shift, Control, Alt (Option on a Mac), and Meta (Command on a Mac, the Windows key)'],
        ];
    @endphp
    <x-docs.table :columns="['Modifier', 'Key']" :rows="$keys" />

    <ul>
        <li><strong>Other keys held don't matter.</strong> <code>nitro:keydown.enter</code> also runs for Ctrl+Enter. To tell them apart, give the Ctrl one a handler of its own: <code>nitro:keydown.ctrl.enter</code>.</li>
        <li><strong>Letters in either case.</strong> <code>.k</code> runs for k and for K, so <code>nitro:keydown.shift.k</code> works though Shift types a capital. With Alt held (Option on a Mac, which types other characters), it is the K key on the keyboard.</li>
        <li><strong>Digits by their key.</strong> <code>.2</code> runs for the 2 key even with Shift held, when it types "@".</li>
        <li><strong>Shortcuts for the whole page</strong> go on an element with <code>.window</code>, and <code>.prevent</code> stops the browser's own (Ctrl+K moves to the address bar in some browsers). Give Mac users <code>.meta</code> as well as <code>.ctrl</code>.</li>
        <li><strong>A wrong name fails the build</strong>, naming the line: <code>nitro:keydown.entr</code> never silently does nothing.</li>
    </ul>

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
            ['`$visit(url)`', 'Go to another page, as a `nitro:navigate` link does'],
        ];
    @endphp
    <x-docs.table :columns="['Action', 'Does']" :rows="$actions" />

    <h2 id="binding">Binding inputs</h2>
    <p>
        <code>nitro:model</code> keeps an input and a property in sync, in both directions.
    </p>

    <x-docs.code src="directive-model.blade.php" lang="blade" />

    <p>
        You can add the <code>.blur</code>, <code>.debounce.300ms</code>, <code>.number</code>,
        <code>.trim</code> and <code>.boolean</code> modifiers. Each change runs the component's
        <code>updated*()</code> hooks (see <a nitro:navigate href="/docs/methods#updated-hooks">Methods</a>).
    </p>

    <h2 id="attributes">Other attributes</h2>
    <p>Nitro has these other attributes:</p>

    @php
        $nitroAttributes = [
            ['`nitro:model="email"`', 'Two-way binding (above)'],
            ['`nitro:loading`', 'Shown while a `#[Server]` call runs. `.remove`, `.class="..."`, `.class.remove="..."`, `.attr="disabled"`; `.delay` (`.delay.500ms`) waits first; `nitro:target="save,delete"` limits it to those methods'],
            ['`nitro:dirty`', 'Shown while the page has changes the server hasn\'t seen. The same forms as `nitro:loading`; `nitro:target="title"` limits it to those properties'],
            ['`nitro:key`', 'Keeps an element\'s identity in a list'],
            ['`nitro:navigate`', 'A link to another page, rendered without a reload (see Navigation). `.keypress`, `.preserve-scroll`, `.transition`'],
            ['`nitro:prefetch`', 'Beside `nitro:navigate`: asks for the page before the click, on hover (`.150ms`: after that wait) or `.visible` when on screen; `.keep.60s` keeps it that long'],
            ['`nitro:current="active"`', 'A class while the link points at the current page; `.exact` for the same path only'],
            ['`nitro:ignore`', 'Leaves the element as it is when the component renders again'],
            ['`nitro:confirm="Delete it?"`', 'Asks before the element\'s handlers run'],
            ['`nitro:poll.30s="refresh"`', 'Calls a method every interval (2.5s by default)'],
            ['`nitro:init="load"`', 'Calls a method once, when the element appears'],
            ['`nitro:visible="loadMore"`', 'Calls a method when the element comes into view'],
            ['`nitro:ref="chart"`', 'The element, as `$refs.chart` in `$this->js()` and for the browser APIs'],
            ['`nitro:transition`', 'Animates the element as it enters and leaves (see Transitions)'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'Does']" :rows="$nitroAttributes" />

    <h3 id="confirm">Asking for confirmation</h3>
    <p>
        <code>nitro:confirm</code> asks the visitor before the element's handlers run. With <code>.prompt</code>,
        the visitor must type a word to confirm, which is the word after the last <code>|</code>:
    </p>

    <x-docs.code src="directive-confirm.blade.php" lang="blade" />

    <h3 id="polling">Polling and reacting to visibility</h3>
    <p>These attributes call a method on a timer, when an element appears, or when it comes into view:</p>

    <x-docs.code src="directive-poll.blade.php" lang="blade" />

    <ul>
        <li>A bare <code>nitro:poll</code> refreshes the component. Polling pauses while the tab is hidden. Add <code>.keep-alive</code> to keep it going, or <code>.visible</code> to poll only while the element is on screen.</li>
        <li>Add <code>.once</code> to <code>nitro:visible</code> to call the method only the first time. While the element stays in view, the method is called again after each call that changed something, so a "load more" row keeps loading until the screen is full.</li>
    </ul>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs, validate them, and show the errors.</x-docs.card>
        <x-docs.card href="/docs/navigation" title="Navigation" icon="arrow">Move between pages without a full reload.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="A component's view is a Blade view. The server renders it with Blade for the first page, and the browser renders it again from its compiled form whenever the state changes, updating only what changed."
>
    <p>
        You write a component's view like any other Blade view, with echoes, <code>@@if</code>,
        <code>@@foreach</code>, <code>@@class</code>, Laravel's helpers and PHP's functions. Because the view also
        runs in the browser, it can only use what works in both places. When something can't run in the browser,
        the build tells you, with the file and line.
    </p>

    <x-docs.example component="contacts" title="A view rendering in the browser" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <p>
        When you type, the list is filtered in the browser. <code>@@forelse</code>, <code>$loop-&gt;first</code>,
        <code>@@class</code> and the <code>Str::</code> helpers all run there, and they give the same results as
        on the server.
    </p>

    <x-docs.pair class="app/Nitro/Components/Contacts.php" view="resources/views/nitro/components/contacts.blade.php" component="contacts" />

    <x-docs.callout type="note" title="One root element">
        <p>A view must have a single root element, which is the component's own element. Everything the view renders goes inside it.</p>
    </x-docs.callout>

    <h2 id="what-works">What you can use in a view</h2>

    @php
        $features = [
            ['Echoes', '`{{ }}`, `{!! !!}`'],
            ['Control flow', '`@if` `@elseif` `@else` `@unless` `@isset` `@empty` `@foreach` (with `$loop`) `@forelse` `@for` `@while` `@break` `@continue` `@switch`'],
            ['Attributes', '`@class` `@style` `@checked` `@selected` `@disabled` `@readonly` `@required`'],
            ['Forms', '`@error` and `$errors`, `@csrf`, `@method`'],
            ['Data', '`@json`'],
            ['Children', 'Components by their tag, with `:key` in a loop'],
            ['Dynamic children', '`nitro:dynamic-component` with `:is`'],
            ['Slots', '`nitro:slot`, printed as `$slot` and `$slots[\'name\']`'],
            ['Teleport', '`@teleport(\'modals\')` ... `@endteleport`, rendered at `@portal(\'modals\')` in the layout'],
            ['Deferred', '`@deferred(\'stats\')` ... `@placeholder` ... `@enddeferred` in a page (see Page data)'],
            ['Laravel helpers', '`route()`, `url()`, `asset()`, `__()` / `trans()`, and `config()` for the keys in `nitro.public_config`'],
            ['PHP', 'Operators, casts and PHP\'s functions: strings, mbstring, arrays, math, ctype, URLs, HTML entities, `preg_*`, `sprintf`, `json_encode` and more, tested against PHP'],
            ['`Str::`', '54 of Laravel\'s string helpers (`slug`, `limit`, `title`, `headline`, `camel`, `snake`, `mask`, `squish`, ...), tested against Laravel'],
        ];
    @endphp
    <x-docs.table :columns="['', 'In a view']" :rows="$features" />

    <p>
        Nitro inlines <code>@@include</code> and anonymous Blade components (<code>&lt;x-panel&gt;</code>) when
        it compiles the view. Anything else, such as <code>@@php</code>, class-based Blade components or custom
        directives, can't run in the browser, and the build fails with the file and line.
    </p>

    <h2 id="echoes">Displaying data</h2>
    <p>
        <code>@{{ $name }}</code> escapes its value, in the browser as on the server. <code>&#123;!! $html !!}</code>
        doesn't escape it, so use it only for HTML you trust. To read a computed value, use
        <code>$this-&gt;total</code>.
    </p>

    <h2 id="children">Rendering child components</h2>
    <p>
        A view can place other components by their tag and pass data to their <code>mount()</code> method (see
        <a nitro:navigate href="/docs/components#placing">Components</a>). Inside a loop, give each one a
        <code>:key</code>. To render a component whose name comes from a value, use
        <code>nitro:dynamic-component</code>:
    </p>

    <x-docs.code src="dynamic.blade.php" lang="blade" />

    <h2 id="slots">Using slots</h2>
    <p>A component can wrap content that its parent passes in. It can receive a default slot and any number of named slots.</p>

    <x-docs.tabs>
        <x-docs.tab label="Using the card">
            <x-docs.code src="slots-use.blade.php" lang="blade" bare />
        </x-docs.tab>
        <x-docs.tab label="card.blade.php">
            <x-docs.code src="slots-card.blade.php" lang="blade" bare />
        </x-docs.tab>
    </x-docs.tabs>

    <p>
        To check whether a slot was given, use <code>$slots-&gt;has('footer')</code> or
        <code>$slot-&gt;isEmpty()</code>. Slot content belongs to the parent, so its handlers and
        <code>nitro:model</code> act on the parent component. In the example above, <code>publish()</code> is the
        parent's method.
    </p>

    <h2 id="teleport">Rendering content elsewhere with teleport</h2>
    <p>
        A modal or a dropdown often needs to render outside the component, at the end of the page.
        <code>@@teleport</code> renders its content where the layout has the matching <code>@@portal</code>, while
        the content stays part of the component:
    </p>

    <x-docs.code src="teleport.blade.php" lang="blade" />

    <h2 id="config">Reading config in the browser</h2>
    <p>
        In a view, <code>config()</code> can only read the keys listed in <code>nitro.public_config</code>, which
        is <code>app.name</code> by default. Their values are sent to the browser, so only list keys that can be
        public:
    </p>

    <x-docs.code src="public-config.php" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/directives" title="Directives" icon="bolt">Handle events, use modifiers and actions, and add nitro: attributes.</x-docs.card>
        <x-docs.card href="/docs/rendering" title="Rendering" icon="browser" runs="browser">Learn how the browser updates only what changed.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

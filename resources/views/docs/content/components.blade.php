<x-docs.page
    lead="A component is a PHP class and its view. The class holds the state and the behaviour; the view shows them. You place it anywhere in Blade with a tag, and it runs in the browser from then on, going to the server only for what needs it."
>
    <p>
        A component is one part of a page: a search box, a cart, a table, a date picker. Its public properties are its
        state. Its methods run in the browser, compiled from the PHP you wrote, so most interactions need no request.
        Methods marked <code>#[Server]</code> run on the server, with the database, mail and anything else Laravel
        has. The view, Blade by default, renders on the server first and in the browser after, from the same template.
    </p>

    <x-docs.example component="faq" title="A component and its children" source="#placing" />

    <h2 id="components-and-pages">Components and pages</h2>
    <p>
        Fusion has two kinds of classes, written the same way. A <strong>component</strong> is placed in a view. A
        <strong>page</strong> is a whole screen with a route, a layout and a title (see
        <a fusion:navigate href="/docs/pages">Pages</a>). Everything on this page is true of both.
    </p>

    @php
        $kinds = [
            ['Class', '`app/Fusion/Components`', '`app/Fusion/Pages`'],
            ['View', '`resources/views/fusion/components`', '`resources/views/fusion/pages`'],
            ['Name', '`students.table` for `App\Fusion\Components\Students\Table`', '`pages::students.index` for `App\Fusion\Pages\Students\Index`'],
            ['Used', 'placed in a view: `<'.'fusion:students.table />`', 'routed: `Route::fusion(\'/students\', Index::class)`'],
            ['Layout and title', 'no', '`#[Layout]`, `#[Title]`'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Components', 'Pages']" :rows="$kinds" />

    <p>
        You can't route a component or place a page inside a view; Fusion's error says what to use instead. The
        directories, namespaces and view paths are in <code>config/fusion.php</code>.
    </p>

    <h2 id="creating">Creating a component</h2>
    <p>
        Write a class that extends <code>Nitro\Fusion\Component</code> in <code>app/Fusion/Components</code>, and its
        view in <code>resources/views/fusion/components</code>, named after the class in kebab case:
        <code>FaqItem</code> has <code>faq-item.blade.php</code>.
    </p>

    <x-docs.pair class="app/Fusion/Components/FaqItem.php" view="resources/views/fusion/components/faq-item.blade.php" component="faq-item" />

    <ul>
        <li><strong>The public properties</strong> (<code>$question</code>, <code>$answer</code>, <code>$open</code>) are its <a fusion:navigate href="/docs/properties">state</a>: rendered by the server, sent to the browser, and sent back with each <code>#[Server]</code> call.</li>
        <li><strong><code>toggle()</code></strong> is a plain method, so it runs in the browser: opening an answer sends nothing to the server.</li>
        <li><strong>The view</strong> has a single root element. Fusion marks it with the component's id and state.</li>
    </ul>

    <h3 id="names">Names and folders</h3>
    <p>
        A component's name comes from its class's place under <code>app/Fusion/Components</code>: each folder is a
        dot, and each part is kebab case. The name is its tag and its view's path:
    </p>

    @php
        $names = [
            ['`App\Fusion\Components\Counter`', '`counter`', '`<'.'fusion:counter />`', '`fusion/components/counter.blade.php`'],
            ['`App\Fusion\Components\FaqItem`', '`faq-item`', '`<'.'fusion:faq-item />`', '`fusion/components/faq-item.blade.php`'],
            ['`App\Fusion\Components\Students\Table`', '`students.table`', '`<'.'fusion:students.table />`', '`fusion/components/students/table.blade.php`'],
        ];
    @endphp
    <x-docs.table :columns="['Class', 'Name', 'Tag', 'View']" :rows="$names" />

    <p>
        <code>#[View]</code> gives a component another view: a Blade view elsewhere, shared by several classes, or a
        view written in <a fusion:navigate href="/docs/javascript-views">Vue, React, Solid or Svelte</a>:
    </p>

    <x-docs.code src="components-view-attribute.php" />

    <h2 id="placing">Placing a component</h2>
    <p>
        A <code>&lt;fusion:...&gt;</code> tag places a component in any Blade view: a page, a layout, a plain Laravel
        view, or another component's view, where it is a <strong>child</strong>. Each tag is its own instance with its
        own state, so opening one answer leaves the others closed:
    </p>

    <x-docs.code src="place-child.blade.php" lang="blade" file="resources/views/fusion/components/faq.blade.php" highlight="2" />

    <p>
        A tag inside PHP (an <code>@@php</code> block, an echo, a string), a Blade comment or <code>@@verbatim</code>
        is text, not a component. In a Blade view that isn't a component's, such as a plain Laravel page, a tag is an
        <a fusion:navigate href="/docs/islands">island</a>, which can start later: when it is visible, when the browser is idle,
        or on interaction.
    </p>

    <h2 id="passing-data">Passing data to a component</h2>
    <p>The tag's attributes are the values the component starts with:</p>

    <x-docs.code src="components-tag-values.blade.php" lang="blade" />

    <ul>
        <li><strong><code>label="Gift wrap"</code></strong> is a string, as written.</li>
        <li><strong><code>:quantity="$quantity"</code></strong> is a PHP expression, worked out in the parent's view: any value, a model, an array.</li>
        <li><strong>Kebab case in the tag is camel case in the class</strong>: <code>:unit-price</code> is <code>$unitPrice</code>.</li>
    </ul>

    <p>Where those values go depends on whether the component has a <code>mount()</code> method.</p>

    <h3 id="into-properties">Into its properties</h3>
    <p>
        Without <code>mount()</code>, each value sets the public property of its name. A name the class doesn't have
        is an error, so a typo in a tag is caught where it is written:
    </p>

    <x-docs.code src="components-properties-in.php" file="app/Fusion/Components/OrderLine.php" runs="both" />

    <p>
        These values <strong>follow the parent</strong>: when the parent's <code>$quantity</code> changes and its view
        renders again, the line's <code>$quantity</code> changes with it. And because nothing has to run on the server,
        the browser can create such a child by itself, when a loop gets a new item or an <code>@@if</code> becomes
        true.
    </p>

    <h3 id="mount">Into mount()</h3>
    <p>
        With <code>mount()</code>, the values are its arguments, by name. It runs once, on the server, when the
        component is created, and it can do server work: load a model, check a policy, call a service. Laravel's
        container calls it, so anything it can give, it can take, as a controller does:
    </p>

    <x-docs.code src="components-mount.php" file="app/Fusion/Components/InvoiceSummary.php" />

    <p>
        A page's <code>mount()</code> takes the route's parameters the same way, with route model binding. See
        <a fusion:navigate href="/docs/pages">Pages</a>.
    </p>

    @php
        $ways = [
            ['Where the values go', 'The public properties of their names', '`mount()`\'s parameters, by name'],
            ['When the parent\'s values change', 'The properties follow them', 'Nothing: `mount()` ran once'],
            ['Server work at creation', 'None', 'Anything: models, policies, services'],
            ['Created in the browser', 'Yes: a new loop item, an `@if` that turns true', 'No: only the server can run `mount()`'],
        ];
    @endphp
    <x-docs.table :columns="['', 'No mount()', 'mount()']" :rows="$ways" />

    <x-docs.callout type="tip" title="Which to choose">
        <p>Pass plain values as properties: a child the browser can make and keep in step costs no request. Use <code>mount()</code> when creating the component needs the server, as <code>InvoiceSummary</code> does to load its lines. A child with <code>mount()</code> is made by the server only: when its loop gets a new item, add the item in a <code>#[Server]</code> method, whose answer brings the new child with it. A browser method that adds one reports an error in the console instead.</p>
    </x-docs.callout>

    <h2 id="keys">Keys and lists</h2>
    <p>
        Fusion tells children apart by their place in the view: the first tag, the second, and inside a loop, its
        index. That is enough while a list only grows at the end. When it is sorted, filtered or added to in the
        middle, give each child a <code>:key</code> from its data, so each keeps its own state as it moves:
    </p>

    <x-docs.code src="components-keys.blade.php" lang="blade" />

    <p>
        A key is unique among the parent's children. The server and the browser number children the same way, so a
        child keeps its state when the browser takes over from the server's HTML.
    </p>

    <h2 id="slots">Slots</h2>
    <p>
        What you put between a component's tags is its <strong>slot</strong>. It renders inside the child, where the
        child's view prints <code>@{{ $slot }}</code>. Named slots go in <code>&lt;fusion:slot name="..."&gt;</code>
        and are printed with <code>@{{ $slots['name'] }}</code>:
    </p>

    <x-docs.code src="components-slots-parent.blade.php" lang="blade" />
    <x-docs.code src="components-slots-child.blade.php" lang="blade" />
    <x-docs.code src="components-panel.php" file="app/Fusion/Components/Panel.php" runs="both" />

    <ul>
        <li><strong>A slot belongs to the parent.</strong> It renders with the parent's values and methods: <code>$members</code> and <code>invite</code> above are the team's, not the panel's. When the team's state changes, the slot updates inside the panel.</li>
        <li><strong>The child decides where</strong>, and whether: the panel shows its slot only while <code>$open</code>.</li>
        <li><strong><code>$slots-&gt;has('footer')</code></strong> says whether a named slot was passed with content; <code>$slot-&gt;isEmpty()</code> the same for the default one.</li>
    </ul>

    <h2 id="binding">Binding a child like an input</h2>
    <p>
        A component of your own can be bound with <code>fusion:model</code>, as an <code>&lt;input&gt;</code> is. Mark
        the property that holds its value with <code>#[Modelable]</code>:
    </p>

    <x-docs.code src="components-modelable.php" file="app/Fusion/Components/DatePicker.php" runs="both" />
    <x-docs.code src="components-modelable.blade.php" lang="blade" />

    <p>
        The child's <code>$value</code> starts as the parent's property, follows it when it changes, and writes it back
        when the child changes it: <code>pick()</code> sets the parent's <code>$startsOn</code>, in the browser, with no
        request. The path can be a key under an array, built in a loop (<code>stops.@{{ $i }}.date</code>). A component
        has one <code>#[Modelable]</code> property.
    </p>

    <h2 id="dynamic">Dynamic components</h2>
    <p>
        <code>&lt;fusion:dynamic-component :is="..."&gt;</code> places the component an expression names, and changes
        it when the expression does. Tabs and wizards are the usual case:
    </p>

    <x-docs.code src="components-dynamic.blade.php" lang="blade" />

    <ul>
        <li>While the name stays the same, the component stays, with its state. Another name is another component: the old one goes, and its state with it.</li>
        <li>An empty string renders nothing. A name that isn't a component, or names a page, is an error.</li>
        <li>Other attributes on the tag are passed to whichever component it places.</li>
    </ul>

    <x-docs.callout type="warning" title="Don't let visitors name it">
        <p>The name is a value in the component's state, which the browser can change. Keep the choice to a list your code checks, such as a <code>match</code> on a tab's key, or <code>#[Locked]</code> when the server picks it.</p>
    </x-docs.callout>

    <h2 id="talking">Components that work together</h2>
    <p>Components are independent: each has its own state, and none reaches into another's. They work together in three ways:</p>
    <ul>
        <li><strong>Down, through the tag</strong>: the values a parent passes, and its slots.</li>
        <li><strong>Up, with <code>fusion:model</code></strong> on a <code>#[Modelable]</code> child, or <strong>across, with <a fusion:navigate href="/docs/events">events</a></strong>: one dispatches, any others listen with <code>#[On]</code>, wherever they are on the page.</li>
        <li><strong>Shared, with <a fusion:navigate href="/docs/sharing-state">stores</a></strong>: state several components read and change, such as a cart.</li>
    </ul>

    <h2 id="where-code-runs">Where your code runs</h2>
    <p>
        The server renders a component first, so the page arrives complete and search engines read it. The browser
        then takes over and runs the compiled class and view from that point on:
    </p>

    @php
        $where = [
            ['`mount()`, `boot()`, `hydrate()`, `dehydrate()`, `exception()`', 'On the server'],
            ['`#[Server]` methods, and hooks marked `#[Server]`', 'On the server, when the browser calls them'],
            ['Other methods, `#[Computed]` methods, `updating*()` and `updated*()` hooks, `mounted()`, `rendered()`, `destroyed()`', 'In the browser'],
            ['The view', 'On the server for the first render, then in the browser'],
        ];
    @endphp
    <x-docs.table :columns="['Code', 'Runs']" :rows="$where" />

    <x-docs.callout type="tip" title="Server-only code can use anything">
        <p>Fusion compiles only the methods the browser can reach. A private helper called only from <code>mount()</code> or a <code>#[Server]</code> method is never compiled, so it can use anything PHP can: Eloquent, facades, packages.</p>
    </x-docs.callout>

    <p>
        Each step of that life, and the hooks you can use at each, are on <a fusion:navigate href="/docs/lifecycle">Lifecycle</a>.
    </p>

    <h2 id="lazy-loading">Loading a component's code later</h2>
    <p>
        Each component's compiled code is in your app's bundle, and pages are chunks of their own. A large component
        that few pages show can be a chunk too, loaded when a page first needs it, with <code>#[LazyLoad]</code>.
        Components that are shown together can share one:
    </p>

    <x-docs.code src="components-lazy.php" />

    <p>
        A page rendered on the server lists the chunks it uses, so the browser loads them at once, and a visit loads a
        page's chunks while it fetches its data. Neither waits for the other.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/properties" title="Properties" icon="book">The state: types, locking, the URL, validation, and what the browser may change.</x-docs.card>
        <x-docs.card href="/docs/methods" title="Methods" icon="browser" runs="browser">PHP that runs in the browser, with no request.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">The database, mail and anything else on the server.</x-docs.card>
        <x-docs.card href="/docs/lifecycle" title="Lifecycle" icon="bolt">What runs when, on the server and in the browser.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

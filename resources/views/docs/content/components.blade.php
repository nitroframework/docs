<x-docs.page
    lead="Components are the building blocks of a Fusion application. Each one is a PHP class paired with a Blade view, and you can place it in any view with a single tag."
>
    <p>
        Fusion has two kinds of classes. A <strong>component</strong> is one part of a page, such as a search
        box, a shopping cart or a table. A <strong>page</strong> is a whole screen, with its own route, layout and
        title (see <a fusion:navigate href="/docs/pages">Pages</a>). You write both the same way, using the same
        properties, methods and views.
    </p>

    <x-docs.example component="faq" title="A component and its children" source="#children" />

    <h2 id="components-and-pages">Components and pages</h2>
    <p>Components and pages differ only in where they live and how you use them:</p>

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
        You can't route a component or place a page inside a view. If you try, Fusion's error message tells you
        what to use instead. You can change these directories, namespaces and view paths in
        <code>config/fusion.php</code>.
    </p>

    <h2 id="a-component">Creating a component</h2>
    <p>
        To create a component, write a class that extends <code>Nitro\Fusion\Component</code> in
        <code>app/Fusion/Components</code>, and its view in <code>resources/views/fusion/components</code>. The
        view's name is the class name in kebab case. For example, the <code>FaqItem</code> class uses the
        <code>faq-item.blade.php</code> view, and you place it with the <code>&lt;fusion:faq-item /&gt;</code>
        tag. Classes in subfolders use a dot in their tag, so <code>Students\Table</code> becomes
        <code>&lt;fusion:students.table /&gt;</code>.
    </p>

    <x-docs.pair class="app/Fusion/Components/FaqItem.php" view="resources/views/fusion/components/faq-item.blade.php" component="faq-item" />

    <p>
        The public properties <code>$question</code>, <code>$answer</code> and <code>$open</code> are the
        component's <a fusion:navigate href="/docs/properties">state</a>. The <code>toggle()</code> method is a
        plain method, so it runs in the browser: opening an answer doesn't send anything to the server. A
        component's view must have a single root element.
    </p>

    <h2 id="children">Passing data to a component</h2>
    <p>
        You can place a component in any Blade view, including another component's view. Attributes prefixed with
        <code>:</code> are passed to the component's <code>mount()</code> method by name. Inside a loop, give each
        component a <code>:key</code> so Fusion can keep track of it when the list changes.
    </p>

    <x-docs.code src="place-child.blade.php" lang="blade" file="resources/views/fusion/components/faq.blade.php" highlight="2" />
    <x-docs.code src="mount-from-tag.php" file="app/Fusion/Components/FaqItem.php" runs="server" />

    <p>
        Each component placed this way has its own state, so opening one answer leaves the others closed.
        <code>mount()</code> runs once, on the server, when the component is created. Its parameters come from the
        tag, or, for a page, from the route, with route model binding.
    </p>

    <h2 id="where-code-runs">Where your code runs</h2>
    <p>
        A component runs in two places. The server renders it first with Blade, so the page arrives complete and
        search engines can read it. The browser then takes over and runs the compiled class and view from that
        point on.
    </p>

    @php
        $where = [
            ['`mount()`, `boot()`, `hydrate()`, `dehydrate()`', 'On the server'],
            ['`#[Server]` methods', 'On the server, when the browser calls them'],
            ['All other methods, `#[Computed]` methods, `updated*()` hooks', 'In the browser'],
            ['The view', 'On the server for the first render, then in the browser'],
        ];
    @endphp
    <x-docs.table :columns="['Code', 'Runs']" :rows="$where" />

    <x-docs.callout type="tip" title="Server-only code can use anything">
        <p>Fusion only compiles the methods the browser can reach. A private helper that you call only from <code>mount()</code> or from a <code>#[Server]</code> method is never compiled, so it can use anything PHP can, such as Eloquent, facades and packages.</p>
    </x-docs.callout>

    <h2 id="lifecycle">Lifecycle hooks</h2>
    <p>Fusion calls these methods at certain points in a component's life, if your component defines them:</p>

    @php
        $hooks = [
            ['`boot()`', 'On the server, on every request'],
            ['`mount(...)`', 'On the server, when the component is created'],
            ['`hydrate()`', 'On the server, when a `#[Server]` call starts'],
            ['`dehydrate()`', 'On the server, before the state is sent to the browser'],
            ['`updatedEmail($value)`', 'In the browser, after `fusion:model` or `$set` changes `$email`'],
            ['`updated($property, $value)`', 'In the browser, after any such change'],
            ['`mounted()`', 'In the browser, once the component is running'],
            ['`destroyed()`', 'In the browser, when the component leaves the page'],
        ];
    @endphp
    <x-docs.table :columns="['Hook', 'Runs']" :rows="$hooks" />

    <x-docs.code src="lifecycle.php" file="app/Fusion/Components/Team.php" />

    <h3 id="javascript">Running JavaScript</h3>
    <p>
        To run a snippet of JavaScript after the next render, call <code>$this-&gt;js('...')</code>. The snippet
        can use <code>$fusion</code> (the component), <code>$refs</code> (its elements marked with
        <code>fusion:ref</code>) and <code>$el</code> (its root element):
    </p>

    <x-docs.code src="component-js.php" runs="browser" highlight="7" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/properties" title="Properties" icon="book">Hold a component's state, lock values, and keep them in the URL.</x-docs.card>
        <x-docs.card href="/docs/methods" title="Methods" icon="browser" runs="browser">Write code that runs in the browser, with no request.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Use the database, mail and anything else on the server.</x-docs.card>
        <x-docs.card href="/docs/events" title="Events" icon="bolt">Let components talk to each other, and to Laravel broadcasting.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

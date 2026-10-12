<x-docs.page
    lead="You write a component once, in PHP. Nitro keeps it in two languages: PHP on the server, and JavaScript in the browser, compiled from your PHP. This page follows one component through both: what the compiler makes of it, what the server sends, what happens on a click and on a server call, and how a Vue, React, Solid or Svelte view gets the component."
>
    <h2 id="two-languages">One component, two languages</h2>
    <p>Take a small component: a counter that counts in the browser and saves on the server.</p>

    <x-docs.code src="how-it-works-counter.php" file="app/Nitro/Components/Counter.php" runs="both" />

    <p>Behind the scenes, a few parts work together. Their names are used through the rest of this page:</p>

    @php
        $cast = [
            ['Component', 'Your PHP class: its state (the public properties) and its behaviour (the methods)'],
            ['Compiler', 'Turns the class, and a Blade view, into JavaScript'],
            ['Definition', 'That JavaScript: the same component, written in JS'],
            ['Runtime', '`nitro.js` in the browser: it holds every live component and runs its methods'],
            ['State', 'The component\'s values, signed by the server, travelling between server and browser'],
            ['Adapter', 'The bridge from a Nitro component to a Vue, React, Solid or Svelte view'],
            ['View', 'What the visitor sees: Blade, or a `.vue`, `.jsx` or `.svelte` file'],
        ];
    @endphp
    <x-docs.table :columns="['Part', 'What it is']" :rows="$cast" />

    <p>
        PHP and JavaScript never call each other. They share <strong>one component in two forms</strong>, the PHP
        class and its compiled definition, and pass its <strong>state</strong> back and forth. The state is the
        handshake: whichever side runs next starts from it.
    </p>

    <h2 id="the-compiler">The compiler</h2>
    <p>
        Nitro reads each component's class and view and compiles them to JavaScript: the component's
        <strong>definition</strong>. In the counter, <code>increment()</code> becomes JavaScript that does what
        <code>$this-&gt;count++</code> does; <code>save()</code> is marked for the server and isn't compiled at all.
        The view becomes a tree of elements with its dynamic parts. During development, this happens on the first
        request after you change a component. For production, you run <code>php artisan nitro:build</code> to do it
        ahead of time.
    </p>
    <ul>
        <li><strong>PHP's rules still hold.</strong> Arrays are values, <code>==</code> compares the way PHP compares, strings are bytes, and functions behave as PHP's do. All of this is checked against PHP itself.</li>
        <li><strong>The browser only gets what it needs.</strong> Nitro never compiles a method the browser can't reach, such as a <code>#[Server]</code> method or a helper that you only call from <code>mount()</code>.</li>
        <li><strong>Mistakes fail the build.</strong> A browser method that queries the database, or a view the browser can't render the same way, causes an error that names the file and line. You find out during development, not in production.</li>
    </ul>

    <h2 id="the-first-render">The first render</h2>
    <p>
        The server runs the PHP class and renders the page with Blade, just as Laravel renders any view. The HTML
        arrives complete, so it appears quickly and search engines and link previews can read it. Along with it
        comes each component's <strong>state</strong>, signed by the server: for the counter,
        <code>count: 0</code>.
    </p>
    <p>
        The browser then takes over the page. The <strong>runtime</strong> finds each component in the HTML,
        creates it from its definition and fills it from its state, so the same counter, at 0, is now alive in the
        browser. It doesn't render the page again: it attaches to the elements the server sent, so nothing moves or
        flickers.
    </p>

    <h2 id="a-click">What happens on a click</h2>
    <p>
        <code>nitro:click="increment"</code> calls the compiled <code>increment()</code> method in the browser. No
        request is sent: the code PHP wrote runs as JavaScript. The method changes <code>$count</code>, and only the
        parts of the view that read <code>$count</code> render again. This works because, when the view was
        compiled, every dynamic part recorded which properties it reads:
    </p>

    <x-docs.code src="fine-grained.blade.php" lang="blade" highlight="3" />

    @php
        $compare = [
            ['Livewire', 'the whole view, on the server', 'the new HTML against the page'],
            ['React, Vue', 'the component’s render function', 'the new virtual DOM against the last one'],
            ['Nitro', 'the expressions that read the property', 'nothing: each one updates its own node'],
        ];
    @endphp
    <x-docs.table :columns="['', 'A change runs', 'Then compares']" :rows="$compare" />

    <h2 id="a-server-call">What happens on a server call</h2>
    <p>
        A method marked <code>#[Server]</code> runs on the server, in PHP. Each call is a single request, and the
        state carries the component across: the server rebuilds the real PHP object from it, runs the method, and
        sends the new state back.
    </p>

    <x-docs.steps>
        <x-docs.step title="The browser sends the signed state">
            <p>It sends the component's state exactly as the server signed it, the properties it has changed since (the counter's <code>count: 1</code>), and the method with its arguments.</p>
        </x-docs.step>
        <x-docs.step title="The server checks everything">
            <ul>
                <li>The state is one the server signed, for this session and this user, and it hasn't been changed.</li>
                <li>The page's middleware (<code>auth</code>, <code>can</code>, ...) still lets the visitor in.</li>
                <li>Every changed property is public, isn't <code>#[Locked]</code>, has its declared type, and passes its <code>#[Validate]</code> rules.</li>
                <li>The method is a <code>#[Server]</code> method, and each argument has its parameter's type.</li>
            </ul>
        </x-docs.step>
        <x-docs.step title="The method runs">
            <p>The server builds the PHP component from the state, with the browser's changes, and runs the method like any other Laravel code, with queries, mail, the session and the container. Models are always read again from the database, never taken from the browser.</p>
        </x-docs.step>
        <x-docs.step title="The browser renders what changed">
            <p>The response holds the new signed state, along with any events, redirects or messages. The runtime takes it in, and only the parts of the view that read a changed property render again.</p>
        </x-docs.step>
    </x-docs.steps>

    <x-docs.callout type="warning" title="The browser can send anything">
        <p>Anyone can call your endpoint without using the page. An unlocked property can arrive with any value of its type. So check whatever a <code>#[Server]</code> method relies on, with <code>#[Validate]</code> rules or <code>$this-&gt;validate()</code>.</p>
    </x-docs.callout>

    <h2 id="javascript-views">JavaScript views: the adapter</h2>
    <p>
        With a Blade view, the runtime renders the view itself: Nitro compiled it. A Vue, React, Solid or Svelte
        view is rendered by its framework, so the component has to reach it. That's the <strong>adapter</strong>'s
        job: it hands the live component to the view in the framework's own way. The component provides; the view
        receives.
    </p>

    @php
        $adapters = [
            ['Blade', 'No adapter: the runtime renders the compiled view', '`{{ $count }}`'],
            ['Vue', 'The component\'s names in the template (refs underneath)', '`{{ count }}`'],
            ['React', 'Its properties and methods, each as a prop', '`function Counter({ count, increment })`'],
            ['Solid', 'Its properties and methods, each as a prop, read where they\'re used', '`props.count`'],
            ['Svelte', 'Its properties and methods, each as a prop', '`let { count, increment } = $props()`'],
        ];
    @endphp
    <x-docs.table :columns="['View', 'How it gets the component', 'Reading the count']" :rows="$adapters" />

    <h3 id="what-a-view-receives">What a view receives</h3>
    <p>
        The adapter spreads the component: each public property, each <code>#[Computed]</code> value and each
        method becomes a prop of its own, under its PHP name. For the counter, a React view gets:
    </p>

    <x-docs.code code="function Counter({ count, increment, save, errors, unsaved, set }) { … }" lang="jsx" />

    @php
        $props = [
            ['`count`', '`public int $count`', 'The value. It updates when the component changes'],
            ['`increment`', '`increment()`', 'A function that runs the compiled method in the browser'],
            ['`save`', '`#[Server] save()`', 'A function that sends the server call. It also carries `save.processing` and `save.slow`'],
            ['`errors`, `unsaved`, `uploads`', 'Nitro', 'Validation messages, changes not yet sent, upload progress'],
            ['`set`, `dispatch`, `link`, `visit`', 'Nitro', 'Write a property, send an event, make a navigate link, visit a page'],
        ];
    @endphp
    <x-docs.table :columns="['Prop', 'Comes from', 'What it is']" :rows="$props" />

    <p>
        So the view never gets the PHP object itself, only those pieces, as if you had written
        <code>&lt;Counter count={…} increment={…} save={…} /&gt;</code>. Protected and private members never reach
        the view, and methods only the server may run arrive as functions that make the request. Vue and Svelte get
        the same pieces: Vue as names in the template, Svelte through <code>$props()</code>.
    </p>

    <p>It works both ways:</p>
    <ul>
        <li><strong>Component to view.</strong> When <code>count</code> changes, by a click or a server call, the adapter tells the framework, which updates what reads it.</li>
        <li><strong>View to component.</strong> An input writes back: <code>v-model</code> in Vue, <code>bind:value</code> in Svelte, <code>set('title', value)</code> in React and Solid. The adapter passes the value to the component, and the runtime sends it with the next server call.</li>
    </ul>
    <p>
        All four adapters share one core: reading values, calling methods, a server call's <code>processing</code>
        and <code>slow</code>, <code>errors</code>, uploads. Each adapter only adds its framework's way of updating
        the page. That's why one PHP class works with all five views: see the
        <a nitro:navigate href="/docs/examples">examples</a>, a blog written five ways.
    </p>

    <h2 id="navigation">Navigation</h2>
    <p>
        A link with <code>nitro:navigate</code> changes the page without a full reload. Laravel routes the visit
        as usual, with its middleware, bindings and redirects, and the browser shows the new page in place of the
        old one. The first visit to any URL always gets the server's complete HTML. These docs work this way.
    </p>

    <h2 id="production">In production</h2>
    <p>
        <code>nitro:build</code> compiles every component, minifies it with esbuild, and publishes versioned files
        to <code>public/nitro</code>. The web server sends these files without PHP, and browsers cache them for a
        year. Each page is in a file of its own, which loads the first time someone visits it. The files hold
        views and browser methods, never data. The state travels with each response.
    </p>

    <x-docs.callout title="In one sentence">
        <p>PHP writes the component once. Nitro compiles it to JavaScript so it runs in the browser, keeps PHP for what must stay on the server, passes signed state between the two, and an adapter hands the live component to your chosen framework as its props.</p>
    </x-docs.callout>

    <x-docs.cards>
        <x-docs.card href="/docs/components" title="Components" icon="browser" runs="both">Write classes and views, and learn where each part runs.</x-docs.card>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="browser" runs="browser">Vue, React, Solid and Svelte views, and what each one gets.</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server" runs="server">See every check a server call goes through.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

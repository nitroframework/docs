<x-docs.page
    lead="In this guide you will build a todo list in a few minutes, with a class, a view, a tag to place it, and one method that runs on the server. The finished component is running below, on this page."
>
    <x-docs.example component="todos" title="What you will build" source="#the-whole-component" />

    <h2 id="the-class">1. Write the class</h2>
    <p>
        Create <code>app/Nitro/Components/Todos.php</code>. The component's public properties are its state.
        Here they hold the list, the title being typed, and the time the list was last saved.
    </p>

    <x-docs.code src="app/Nitro/Components/Todos.php" file="app/Nitro/Components/Todos.php" highlight="12,14,17" />

    <ul>
        <li><code>mount()</code> runs <strong>on the server</strong> when the component is created. It loads the saved list.</li>
        <li><code>add()</code> and <code>toggle()</code> are plain methods. They run <strong>in the browser</strong>, so adding and ticking off todos doesn't send anything to the server.</li>
        <li><code>remaining()</code> is marked <code>#[Computed]</code>. You read it as <code>$this-&gt;remaining</code>, and Nitro works it out once and keeps it until the list changes.</li>
        <li><code>save()</code> is marked <code>#[Server]</code>, so it runs <strong>on the server</strong>. The list comes from the browser, so <code>save()</code> validates it before storing it.</li>
        <li><code>$savedAt</code> is marked <code>#[Locked]</code>. The browser can read it, but only the server can set it.</li>
    </ul>

    <x-docs.callout type="note" title="This demo saves to the session">
        <p>So that the example works for every visitor, without an account or a database, <code>save()</code> keeps the list in your session. Your application would save it to the database in the same way. The call to the server, the validation and the new state that comes back all stay the same.</p>
    </x-docs.callout>

    <h2 id="the-view">2. Write the view</h2>
    <p>
        Create <code>resources/views/nitro/components/todos.blade.php</code>. The view is ordinary Blade, so
        <code>@@foreach</code>, <code>@@class</code>, <code>@@checked</code> and echoes work as they always do.
        The <code>nitro:</code> attributes connect the view to the class.
    </p>

    <x-docs.code src="resources/views/nitro/components/todos.blade.php" lang="blade" file="resources/views/nitro/components/todos.blade.php" highlight="2,3,11,23" />

    @php
        $directives = [
            ['`nitro:submit="add"`', 'Calls `add()` when the form is submitted, without reloading the page'],
            ['`nitro:model="title"`', 'Keeps the input and `$title` in sync'],
            ['`nitro:click="toggle($i)"`', 'Calls `toggle()` with the row\'s index'],
            ['`nitro:loading.attr="disabled"`', 'Disables the button while `save()` runs'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'What it does']" :rows="$directives" />

    <h2 id="place-it">3. Place the component</h2>
    <p>
        You place a component in any Blade view with its tag. The tag is the class name in kebab case, so
        <code>Todos</code> becomes <code>todos</code>, and <code>Posts\Table</code> would become
        <code>posts.table</code>.
    </p>

    <x-docs.code src="place-todos.blade.php" lang="blade" file="resources/views/todos.blade.php" highlight="4" />
    <x-docs.code src="route-todos.php" file="routes/web.php" />

    <p>
        Now open <code>/todos</code>. The server renders the list with Blade, so the page arrives complete. The
        browser then takes over. Type a todo, press enter, and tick it off. Nothing is sent to the server until
        you press <strong>Save</strong>. If you reload after saving, the list is still there, because
        <code>mount()</code> loaded it.
    </p>

    <x-docs.callout type="tip" title="Watch the network tab">
        <p>Adding and ticking off todos makes no request. Saving makes exactly one. The component's signed state goes to the server, <code>save()</code> runs, and the new state comes back.</p>
    </x-docs.callout>

    <h2 id="a-page">4. Turn it into a page (optional)</h2>
    <p>
        A component is one part of a page. When it fills the whole screen, you can turn it into a
        <strong>page</strong> instead. Move the class to <code>app/Nitro/Pages</code> and its view to
        <code>nitro/pages</code>, then give it a route. A page has its own layout and title, and loads its data
        in <code>mount()</code>.
    </p>

    <x-docs.code src="make-page.php" file="routes/web.php" />

    <h2 id="the-whole-component">The whole component</h2>
    <p>Here are the class and the view side by side, along with the JavaScript that Nitro compiles them to.</p>

    <x-docs.pair class="app/Nitro/Components/Todos.php" view="resources/views/nitro/components/todos.blade.php" component="todos" />

    <x-docs.cards>
        <x-docs.card href="/docs/how-it-works" title="How Nitro works" icon="book">Learn what happened when you clicked: the compiler, the first render and a server call.</x-docs.card>
        <x-docs.card href="/docs/components" title="Components" icon="browser" runs="both">See everything a component can do.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-docs.page
    lead="Nitro's rendering is fine-grained. Each dynamic part of a view knows which properties it reads, so when a property changes, only those parts run and only their nodes change. Nothing is compared."
>
    <p>
        When Nitro compiles a view, every dynamic part of it records which properties it reads. A dynamic part
        is an echo, an attribute, an <code>@@if</code>, a <code>@@foreach</code> or a child's props. When a
        property changes, only the parts that read it run again, and each one updates its own node.
    </p>

    <x-docs.example component="render-demo" title="Only what changed" source="#the-component" />

    <p>
        Click <strong>+</strong>, and only one number flashes. Type a name, and only the greeting changes. Enrol a
        student, and one new row is added while the twenty rows already there are left alone.
    </p>

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Nitro/Components/RenderDemo.php" view="resources/views/nitro/components/render-demo.blade.php" component="render-demo" />

    <h2 id="what-reads-what">How Nitro tracks what each part reads</h2>
    <p>Each highlighted line below reads one property, so it runs again only when that property changes:</p>

    <x-docs.code src="fine-grained.blade.php" lang="blade" highlight="3,4,6" />

    <p>Here is how this compares with other frameworks, when one property changes:</p>

    @php
        $compare = [
            ['Livewire', 'The whole view, on the server', 'The new HTML against the page'],
            ['React, Vue', 'The component\'s render function', 'The new virtual DOM against the last one'],
            ['Nitro', 'The expressions that read the property', 'Nothing. Each expression updates its own node'],
        ];
    @endphp
    <x-docs.table :columns="['', 'What runs again', 'What is compared']" :rows="$compare" />

    <ul>
        <li><strong>Methods are followed.</strong> Nitro works out what a part reads at compile time, through the methods it calls. An echo of <code>$this-&gt;total()</code> reads whatever <code>total()</code> reads.</li>
        <li><strong><code>#[Computed]</code> values are cached</strong> until the state they read changes.</li>
        <li><strong><code>$errors</code>, <code>$this-&gt;shared()</code> and <code>$this-&gt;flashed()</code></strong> are tracked just like properties.</li>
        <li><strong>Updates from the server work the same way.</strong> A <code>#[Server]</code> answer, a reload or a parent's new props only render the parts that read what changed.</li>
        <li><strong>Keyed lists</strong> (<code>nitro:key</code>, <code>:key</code>) move, add and remove rows, and leave the other rows alone.</li>
    </ul>

    <h2 id="creating-elements">Choosing how elements are created</h2>
    <p>
        The browser creates new elements when you visit a page, when an <code>@@if</code> turns true, or when a list
        gains rows. The <code>nitro.rendering</code> setting decides how it creates them. The result is the same
        either way, and the first page load always uses the server's HTML as it is.
    </p>

    <x-docs.code src="rendering-config.php" />

    @php
        $modes = [
            ['`\'clone\'` (default)', 'Each static part of a view is built once, then copied'],
            ['`\'create\'`', 'Every element is created one by one'],
        ];
    @endphp
    <x-docs.table :columns="['Setting', 'How elements are created']" :rows="$modes" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/production" title="Building for production" icon="server">Compile, minify and publish your bundle.</x-docs.card>
        <x-docs.card href="/docs/how-it-works" title="How Nitro works" icon="book">Learn how the compiler, the runtime and the endpoint fit together.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

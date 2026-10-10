<x-docs.page
    lead="Select boxes, date pickers, rich editors and charts written for plain JavaScript work in a Nitro component. Write the library's binding once, as an attribute of your own, and Nitro starts it, keeps its value in step with a property, and tears it down, wherever the element comes and goes."
>
    <p>
        A library such as select2 or Flatpickr takes over an element: it hides it, builds markup of its own beside
        it, and reports changes in its own way. Three things make it work with a component that renders again:
    </p>
    <ul>
        <li><strong>The library owns its markup.</strong> Wrap it in <code>nitro:ignore</code>, so a render never touches what it built.</li>
        <li><strong>The value goes both ways.</strong> When the visitor chooses, the library sets the property; when anything else changes the property, the library shows it.</li>
        <li><strong>It is torn down.</strong> When its element leaves the page, the library's instance goes with it.</li>
    </ul>
    <p>
        A <code>nitro:</code> attribute of your own does all three in one place. Nitro runs it when its element
        appears and cleans it up when the element goes, so the same binding works after a visit, in an
        <code>@@if</code>, in a new row of a list, and after the back button, with no event to listen for.
    </p>

    <h2 id="binding">Binding a library</h2>
    <x-docs.steps>
        <x-docs.step title="Name the attribute">
            <p>List it in <code>config/nitro.php</code>, so the compiler accepts it:</p>
            <x-docs.code src="libraries-config.php" />
        </x-docs.step>

        <x-docs.step title="Write the binding">
            <p>
                Register a directive of the same name in a script your layout loads, with the library. It receives the
                element, the attribute's value (here, the property's name) and the component. The last two lines
                register it whenever the script runs: before Nitro starts, on a page's first load, or after, when a
                visit brings the layout that loads it:
            </p>
            <x-docs.code src="libraries-select2.js" lang="js" highlight="7,10,13,16,26,27" />
        </x-docs.step>

        <x-docs.step title="Use it">
            <x-docs.code src="libraries-use.blade.php" lang="blade" highlight="1,2" />
        </x-docs.step>
    </x-docs.steps>

    @php
        $handle = [
            ['`component.get(path)`', 'The property\'s value (`lines.2.product`: a key under it), as plain data'],
            ['`component.set(path, value)`', 'Sets it, as `nitro:model` does: its `updated*()` hooks run, and the view renders the change'],
            ['`component.watch(path, fn)`', 'Calls `fn(value)` whenever the value changes from anywhere else: a browser method, the server\'s answer, a reset, another library on the same property. Not for this binding\'s own `set()`, so the value never echoes back. Returns a function that stops watching'],
            ['`component.call(method, ...args)`', 'Runs a method: a browser one returns its value, a `#[Server]` one a promise of it'],
            ['`component.dispatch(event, ...)`', 'Sends an event, as `$this->dispatch()` does'],
        ];
    @endphp
    <x-docs.table :columns="['The component', 'Does']" :rows="$handle" />

    <x-docs.callout type="tip" title="Why the namespaced event">
        <p>select2 reports a choice with jQuery's <code>change</code> event, and so does your own <code>.trigger()</code>. Listening to <code>change.nitro</code> and triggering <code>change.select2</code> keeps the two apart: what the visitor did reaches the property, what the property did reaches select2 only. Most libraries have the same: a quiet way to set the value (Flatpickr's <code>setDate(value, false)</code>, Tom Select's <code>setValue(value, true)</code>).</p>
    </x-docs.callout>

    <h2 id="handled">What Nitro takes care of</h2>
    <p>Write the binding once, and these work with no more code:</p>
    <ul>
        <li><strong>A visit.</strong> <code>nitro:navigate</code> to another page tears every library down; back, each starts again, once, with the page's values. There is no <code>navigated</code> event to listen for, and nothing starts twice. The back button too.</li>
        <li><strong>Arriving by a visit.</strong> From a page of the same layout, the libraries start as the page shows. From a page without them, into a page whose layout loads them, the libraries and your bindings load with the visit, after the page's components started: Nitro runs a binding registered then on the elements already there.</li>
        <li><strong>An <code>@@if</code>.</strong> When the block goes, its libraries are torn down; when it comes back, they start with the property's value at that moment.</li>
        <li><strong>A list.</strong> A new row's library starts, bound to its own row; a removed row's goes.</li>
        <li><strong>Renders.</strong> A render of anything else leaves the library and its markup as they are.</li>
        <li><strong>The server.</strong> A <code>#[Server]</code> method that changes the property reaches the library with its answer.</li>
        <li><strong>An obfuscated build.</strong> The binding uses your property names; Nitro translates them.</li>
    </ul>
    <p>
        Nitro's own browser tests run select2, Flatpickr, Tom Select, Choices, Trix, Quill, SortableJS, noUiSlider and
        IMask through each of these, every way into the page, with the bindings on this page.
    </p>

    <h2 id="recipes">Recipes</h2>
    <h3 id="flatpickr">Flatpickr</h3>
    <x-docs.code src="libraries-flatpickr.js" lang="js" />
    <h3 id="tom-select">Tom Select</h3>
    <x-docs.code src="libraries-tom-select.js" lang="js" />
    <h3 id="choices">Choices</h3>
    <x-docs.code src="libraries-choices.js" lang="js" />
    <h3 id="trix">Trix</h3>
    <p>Trix needs a hidden input beside its editor; the binding makes both, so the view has one element:</p>
    <x-docs.code src="libraries-trix.js" lang="js" />
    <h3 id="quill">Quill</h3>
    <x-docs.code src="libraries-quill.js" lang="js" />
    <h3 id="sortable">SortableJS</h3>
    <p>The library moves the list's items itself, so the binding draws them from the property, and the property keeps the order:</p>
    <x-docs.code src="libraries-sortable.js" lang="js" />
    <h3 id="slider-mask">noUiSlider and IMask</h3>
    <x-docs.code src="libraries-slider-mask.js" lang="js" />

    <h2 id="nitro-script">One component's script: @@nitroScript</h2>
    <p>
        When a library belongs to one component only, such as a chart, write its code in the component's view.
        <code>@@nitroScript</code> runs once for each instance of the component, as it goes live:
    </p>
    <x-docs.code src="libraries-script.blade.php" lang="blade" />
    <ul>
        <li><strong>What it can use.</strong> <code>$refs</code> (elements marked <code>nitro:ref</code>), <code>$el</code> (the component's root element), <code>$component</code> (the same <code>get</code>, <code>set</code>, <code>watch</code> as above) and <code>$nitro</code> (the component as <code>$this-&gt;js()</code> has it: <code>$nitro.views</code>, <code>$nitro.save()</code>).</li>
        <li><strong>Once for each instance.</strong> Two charts on a page run it twice, each with its own <code>$refs</code>. A render never runs it again; a new instance (after a visit, in an <code>@@if</code> that comes back) does.</li>
        <li><strong>Cleaning up.</strong> A function it returns runs when the component leaves the page.</li>
        <li><strong>In the root element, outside blocks.</strong> Inside an <code>@@if</code> or a <code>@@foreach</code> it is a build error: whether it ran would depend on the block.</li>
        <li><strong>Never on the server.</strong> The server renders nothing of it, and Blade never reads it, so <code>@{{ }}</code> and <code>@@</code> in your JavaScript are just JavaScript. The <code>&lt;script&gt;</code> tag is optional, for your editor.</li>
    </ul>

    <x-docs.callout type="note" title="Loading the library itself">
        <p>Load the library (jQuery, select2, Flatpickr), then your bindings, once, in your layout or your Vite bundle. A binding or a <code>@@nitroScript</code> only uses the library. A layout of its own can load them in its <code>&lt;head&gt;</code>: a visit into it loads them, in their order.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/extending" title="Extending Nitro" icon="code">Your own nitro: attributes, plugins and server features.</x-docs.card>
        <x-docs.card href="/docs/javascript-views" title="JavaScript views" icon="code">A whole view in Vue, React, Solid or Svelte, when the library belongs to that framework.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

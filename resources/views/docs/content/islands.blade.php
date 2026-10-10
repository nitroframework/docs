<x-docs.page
    lead="Islands let you add live components to pages that aren't Nitro pages. The page stays plain HTML, and each component starts on its own: right away, later, or never."
>
    <p>
        Not every page needs to be a Nitro page. A marketing page, a blog post or a layout can stay plain Blade
        and still contain components. Each component placed this way is an <strong>island</strong>. The server
        renders it with the rest of the page, and the browser starts it on its own. You choose when with
        <code>nitro:hydrate</code>. Until an island starts, it is just the server's HTML, and it costs the
        browser nothing.
    </p>
    <p>
        The plain page needs Nitro in its layout as a Nitro page does: <code>@@nitroScripts</code> before
        <code>&lt;/body&gt;</code> (and <code>@@nitroHead</code> in the <code>&lt;head&gt;</code> if you want its tags).
        Without it, the islands show but never start.
    </p>

    <x-docs.cards>
        <x-docs.card href="/demo/islands" title="Open the islands demo" icon="bolt">A plain Blade page with four islands. Each starts in its own way, and its label shows whether it is waiting or live.</x-docs.card>
    </x-docs.cards>

    <h2 id="when">Choosing when an island starts</h2>
    <p>Add <code>nitro:hydrate</code> with a modifier to the island's tag:</p>

    <x-docs.code src="islands-tags.blade.php" lang="blade" />

    @php
        $moments = [
            ['(none)', 'With the page'],
            ['`nitro:hydrate.idle`', 'When the browser is idle'],
            ['`nitro:hydrate.visible`', 'When it comes into view. With `.visible.200px`, when it is that close'],
            ['`nitro:hydrate.interaction`', 'On the first click, focus, key press or input inside it. Nitro replays the click once the island is live, and passes typed text to `nitro:model`'],
            ['`nitro:hydrate.media="(query)"`', 'When the media query matches'],
            ['`nitro:static`', 'Never. It stays the server\'s HTML, and no state is sent'],
        ];
    @endphp
    <x-docs.table :columns="['Attribute', 'The island starts']" :rows="$moments" />

    <ul>
        <li><strong>Before it starts</strong>, an island is the server's HTML, and anything typed into it is kept.</li>
        <li><strong>Its slots</strong> are rendered again in the browser once it starts.</li>
        <li><strong>Inside a component's view</strong>, children always start with their parent, so <code>nitro:hydrate</code> there is a build error. Islands belong in plain Blade views and layouts.</li>
    </ul>

    <h3 id="directive">Placing an island by name</h3>
    <p>
        When the component's name is only known at runtime, from a setting or a database row, place it with the
        <code>@@nitro</code> directive instead of a tag. It takes the name, the props, and optionally its slots'
        HTML and when it starts: <code>'idle'</code>, <code>'visible'</code>, <code>'interaction'</code>,
        <code>'media:(max-width: 768px)'</code>, or <code>'static'</code> for never:
    </p>

    <x-docs.code src="islands-directive.blade.php" lang="blade" />

    <p>
        <code>@@nitro('posts.table')</code> is the same island as <code>&lt;nitro:posts.table /&gt;</code>.
        Use the tag when you know the name as you write the view.
    </p>

    <h2 id="code">Loading an island's code later</h2>
    <p>Add <code>#[LazyLoad]</code> to the island's class, and the browser downloads its code only when the island starts, not with the page:</p>

    <x-docs.code src="islands-lazy.php" />

    <x-docs.callout type="tip" title="These docs are Nitro pages">
        <p>Every docs page is a Nitro page, where components start with the page, so the demo has a page of its own. Open it, scroll down, click in the first island, and watch the labels change.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/pages" title="Pages" icon="book">Make the whole screen a Nitro page, with its own route.</x-docs.card>
        <x-docs.card href="/docs/production" title="Building for production" icon="server">Build your components ahead of time, in chunks the browser loads when it needs them.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

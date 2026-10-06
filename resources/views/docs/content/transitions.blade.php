<x-docs.page
    lead="Transitions animate elements as they enter and leave the page. Add fusion:transition to an element inside an @if or a @foreach, and Fusion animates it when it appears and when it goes."
>
    <p>
        To animate an element, add <code>fusion:transition</code> to an element that an <code>@@if</code> or a
        <code>@@foreach</code> renders. The element animates as it enters. When it leaves, Fusion keeps it in the
        page until its animation ends. Without a name, the transition is a built-in fade and scale that needs no
        CSS.
    </p>

    <x-docs.example component="transition-demo" title="Entering, leaving and moving" source="#the-component" />

    <p>
        Try adding and removing names, then shuffle the list. The rows that stay slide to their new places, thanks
        to <code>.move</code>. When you switch tabs, the old tab leaves before the new one enters, thanks to
        <code>.out-in</code>. When you open the panel, it uses the built-in fade and scale, growing from its top
        edge.
    </p>

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Fusion/Components/TransitionDemo.php" view="resources/views/fusion/components/transition-demo.blade.php" component="transition-demo" />

    <h2 id="built-in">Using the built-in transition</h2>
    <p>The built-in transition fades and scales the element. Modifiers let you change how it animates:</p>

    <x-docs.code src="transitions-builtin.blade.php" lang="blade" />

    @php
        $modifiers = [
            ['`.opacity`, `.scale`', 'Fade only, or scale only (both by default)'],
            ['`.duration.300ms`', 'The duration, 150ms by default'],
            ['`.origin.top`', 'The transform origin: `top`, `bottom`, `left`, `right` or `center`'],
            ['`.in`, `.out`', 'Animate only when entering, or only when leaving'],
            ['`.appear`', 'Animate on the component\'s first render in the browser too'],
            ['`.out-in`, `.in-out`', 'For an element that replaces another (`@if` and `@else`, on both): the old one leaves before the new one enters, or after it'],
            ['`.move`', 'On the rows of a `@foreach`: the rows that stay slide to their new places when the list changes'],
        ];
    @endphp
    <x-docs.table :columns="['Modifier', 'Effect']" :rows="$modifiers" />

    <h2 id="named">Writing your own transition</h2>
    <p>
        When you give a transition a name, your CSS classes decide what moves and for how long. This works the
        same way as Vue's transitions:
    </p>

    <x-docs.code src="transitions-named.blade.php" lang="blade" />
    <x-docs.code src="transitions-named.css" lang="css" />

    <h2 id="lists">Animating lists and tabs</h2>
    <p>
        Give each row of a list a <code>fusion:key</code>, so Fusion can follow it as the list changes. When two
        elements replace each other, put <code>.out-in</code> on both of them.
    </p>

    <x-docs.code src="transitions-list.blade.php" lang="blade" highlight="2,6,8" />

    <x-docs.callout type="note" title="When nothing animates">
        <p>Fusion doesn't animate the server's HTML, elements in a hidden tab, or anything for visitors who have asked their system for reduced motion.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/islands" title="Islands" icon="bolt">Add components to plain Blade pages, and start them when they are needed.</x-docs.card>
        <x-docs.card href="/docs/rendering" title="Rendering" icon="browser" runs="browser">Learn how the browser updates only what changed.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

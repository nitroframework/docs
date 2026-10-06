<x-docs.page
    lead="Each component's state belongs to that component. When several components need the same state, and need it for longer than any one of them lives, you can keep it in a store that they all share."
>
    <h2 id="today">Sharing state with events</h2>
    <p>
        Let's start without a store. The examples below are three components that aren't parent and child: a
        product list, a badge and a cart in a drawer. The product list dispatches an event each time you add a
        product. The badge and the cart listen for it, and each one keeps its own copy of the cart. Add a few
        products, then open the cart.
    </p>

    <x-docs.example component="shop-badge" title="The badge" source="#today-code" />
    <x-docs.example component="shop-products" title="The products" source="#today-code" />
    <x-docs.example component="shop-drawer" title="The drawer" source="#today-code" />

    <p>
        The cart opens empty. Fusion only creates it when you open the drawer, which is after the events were
        dispatched, and an event only reaches the components that are on the page at that moment. If you remove
        an item after adding more, the badge only updates because the cart dispatches an event back.
    </p>

    <h3 id="today-code">The code</h3>
    <x-docs.pair class="app/Fusion/Components/ShopBadge.php" view="resources/views/fusion/components/shop-badge.blade.php" component="shop-badge" />
    <x-docs.pair class="app/Fusion/Components/ShopCart.php" view="resources/views/fusion/components/shop-cart.blade.php" component="shop-cart" />

    <p>This approach has a few problems:</p>
    <ul>
        <li><strong>Every component keeps a copy.</strong> The badge and the cart each store the cart in their own shape, so every change is written twice.</li>
        <li><strong>Components created later miss events.</strong> A component created after an event never hears it. The drawer's cart is one example, and a cart page you visit later is another.</li>
        <li><strong>A visit loses everything.</strong> When you visit another page, its components replace the old ones, and their copies are gone.</li>
        <li><strong>The server is slower.</strong> You could keep the cart in the session instead. However, every add would then need a request to the server, which is exactly what Fusion's browser methods avoid.</li>
    </ul>

    <h2 id="store">Sharing state with a store</h2>
    <p>
        Here are the same three components, with the cart kept in a <strong>store</strong>. A store is one place
        for a piece of state and the methods that change it, and every component that uses it shares it. Add a
        few products, then open the cart.
    </p>

    <x-docs.example component="store-badge" title="The badge" source="#store-code" />
    <x-docs.example component="store-products" title="The products" source="#store-code" />
    <x-docs.example component="store-drawer" title="The drawer" source="#store-code" />

    <p>
        This time the cart opens with everything you added, because it reads the store as it is whenever it is
        created. Remove an item and the badge updates too, without any event. You can also visit another page of
        these docs and come back: the store stays as long as the tab is open.
    </p>

    <h3 id="store-code">The code</h3>
    <p>You write a store like a component without a view, and you put it in <code>app/Fusion/Stores</code>:</p>

    <x-docs.code src="app/Fusion/Stores/Cart.php" file="app/Fusion/Stores/Cart.php" />

    <x-docs.callout type="note" title="Saved in the session, for this demo">
        <p>So that the example works for every visitor, <code>save()</code> keeps the cart in your session, and <code>mount()</code> reads it back so a reload keeps it. Your app would save the cart to the database instead.</p>
    </x-docs.callout>

    <p>To use a store, give a component a property of the store's type. The component can then call the store's methods from its view:</p>

    <x-docs.pair class="app/Fusion/Components/StoreBadge.php" view="resources/views/fusion/components/store-badge.blade.php" component="store-badge" />
    <x-docs.pair class="app/Fusion/Components/StoreCart.php" view="resources/views/fusion/components/store-cart.blade.php" component="store-cart" />

    <ul>
        <li><strong>One store, shared.</strong> Every component with a <code>public Cart $cart</code> property gets the same store. On the server, there is one store per request, created with its <code>mount()</code>. In the browser, there is one store per tab, and it is kept across visits.</li>
        <li><strong>Only what reads it renders again.</strong> When the store's methods change it, Fusion renders again only the parts that read the store, in every component that uses it.</li>
        <li><strong>You change it through its methods.</strong> Components read the store and call its methods. Writing to a store from outside fails the build. The store's methods run in the browser, and its <code>#[Server]</code> methods, such as <code>save()</code>, run on the server with the store's signed state.</li>
    </ul>

    <h2 id="persist">Keeping and sharing a store</h2>
    <p>
        By default, a store lasts as long as its tab. Two attributes let you keep it for longer, or share it with
        the site's other tabs:
    </p>

    <x-docs.code src="store-persist.php" file="app/Fusion/Stores/Cart.php" highlight="6,9" />

    <ul>
        <li><strong><code>#[Persist]</code></strong> keeps the store's values in the browser's localStorage, so they outlast a reload or a closed tab. When the store is created, Fusion sets the kept values as the browser's own changes.</li>
        <li><strong><code>#[Sync]</code></strong> shares the values with the site's other open tabs. A change in one tab is set in the others. A tab you open later starts from the server's state, or, with <code>#[Persist]</code>, from the kept values.</li>
        <li><strong>Where you put them matters.</strong> On the store class, they cover every property the browser can change. On a property, they cover only that property. A <code>#[Locked]</code> property belongs to the server, so the store attributes skip it, and putting either attribute on one fails the build.</li>
        <li><strong>They are for stores only.</strong> A component's state belongs to that component, so a component can't use them.</li>
    </ul>

    <x-docs.callout type="warning" title="Kept values are checked like any change">
        <p>The browser holds these values, so a visitor can change them. Fusion treats restored and synced values as ordinary browser changes, and the server checks them on the next call, just like any other change: their type, <code>#[Locked]</code> and <code>#[Validate]</code>. Read anything that must be true, such as prices or stock, from the database in your <code>#[Server]</code> methods.</p>
    </x-docs.callout>

    <p>
        If the browser has no localStorage (for example, when it is blocked or in a private window) or no
        BroadcastChannel, the store works as if the attributes weren't there.
    </p>

    <h2 id="which">Which to use</h2>
    <p>
        Keep state in the component that owns it. Move it to a store only when components that aren't parent and
        child need it, or when it must outlive the component that holds it now. A form's fields, a toggle, or a
        list that a table filters belong in properties. A cart, the signed-in user's preferences, a wizard that
        spans several pages, or a queue of notifications belong in a store.
    </p>
</x-docs.page>

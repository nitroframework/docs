<x-docs.page
    lead="#[Cached] keeps what a slow mount() or #[Server] method works out, in your application's cache. The next request with the same inputs gets the result without running the method, until time runs out or a save expires it with Nitro::expire()."
>
    <p>
        A report that counts thousands of rows, a lookup that calls a slow service, a list every visitor sees the
        same: the work is the same each time, until the data changes. Mark the method <code>#[Cached]</code> and
        Nitro runs it once, keeps its result, and answers from the cache after. When the data changes, call
        <code>Nitro::expire()</code> with a tag, and the next request works it out again.
    </p>

    <h2 id="mount">Caching mount()</h2>
    <p>
        Put <code>#[Cached]</code> on <code>mount()</code>, with how many seconds to keep the result and the
        tags that can expire it:
    </p>

    <x-docs.code src="cached-mount.php" file="app/Nitro/Pages/Stats/Categories.php" highlight="20" runs="server" />

    <ul>
        <li><strong>What is kept.</strong> The properties as <code>mount()</code> left them. On the next request, Nitro sets them from the cache and skips <code>mount()</code>.</li>
        <li><strong>Kept by its inputs.</strong> A result belongs to what <code>mount()</code> started from: its arguments (the tag's values, or the route's parameters) and the properties before it ran, such as <code>#[Url]</code> values. <code>?status=graduated</code> is a result of its own.</li>
        <li><strong>The view still renders.</strong> Only <code>mount()</code>'s work is kept. Each request renders the page and signs its state as usual.</li>
        <li><strong>It works on components too.</strong> A component's <code>mount()</code> is kept by the values its tag passes.</li>
    </ul>

    <x-docs.callout type="warning" title="Keep a cached mount() to loading properties">
        <p>On a cache hit, <code>mount()</code> doesn't run, so nothing else it does happens: <code>$this-&gt;head()</code>, <code>$this-&gt;defer()</code>, <code>Nitro::share()</code> and <code>Nitro::flash()</code> happen only on the request that filled the cache. Give a cached page its title with <code>#[Title]</code>, and keep checks such as <code>Gate::authorize()</code> in the route's middleware, which runs on every request. Or cache only the slow part, as below.</p>
    </x-docs.callout>

    <h2 id="part-of-mount">Caching only the slow part</h2>
    <p>
        When <code>mount()</code> does more than load data, keep the slow part in a method of its own, with
        Laravel's <code>Cache::remember()</code>, and call it from <code>mount()</code>. The rest of
        <code>mount()</code> then runs on every request: the check, the head, the shared data.
    </p>

    <x-docs.code src="cached-helper.php" highlight="8,14" runs="server" />

    <p>
        The helper is private and only <code>mount()</code> calls it, so it is never compiled for the browser, and
        it can use the cache like any Laravel code. You choose its key: put in it everything the result depends on,
        here the status. Forget it where the data changes:
    </p>

    <x-docs.code src="cached-helper-forget.php" runs="server" />

    @php
        $ways = [
            ['What is kept', 'What `mount()` or the method leaves in the properties', 'What the helper returns'],
            ['The rest of `mount()`', 'Skipped on a hit', 'Runs every time'],
            ['The key', 'Worked out by Nitro, from the inputs and `by`', 'Yours to write'],
            ['Forgetting it', '`Nitro::expire()` with a tag, on any store', '`Cache::forget()` with its key, or Laravel\'s cache tags on a store that has them'],
            ['A change to the class', 'Starts afresh', 'Kept: forget it in your deploy'],
        ];
    @endphp
    <x-docs.table :columns="['', '`#[Cached]` on `mount()`', '`Cache::remember()` in a helper']" :rows="$ways" />

    <x-docs.callout type="note" title="Why not #[Cached] on the helper?">
        <p><code>#[Cached]</code> goes on <code>mount()</code> and <code>#[Server]</code> methods only, because Nitro is the one that calls them, so it can answer from the cache instead. A helper is called by your own code, <code>$this-&gt;byCategory()</code>, and Nitro is not in between. On any other method, <code>#[Cached]</code> fails the build.</p>
    </x-docs.callout>

    <h2 id="expire">Forgetting a result</h2>
    <p>
        A result is kept for its seconds (60 by default), or until one of its tags expires. Expire a tag where the
        data changes, such as the <code>#[Server]</code> method that saves:
    </p>

    <x-docs.code src="cached-expire.php" runs="server" />

    <p>
        <code>Nitro::expire('posts', 'comments')</code> takes any number of tags. Every result kept under one of
        them, on any page or component, is worked out again on its next request. Results without that tag are left
        alone. Expiring works on every cache store, including those without tag support, such as
        <code>file</code> and <code>database</code>.
    </p>
    <p>
        A deploy that changes the component's class starts afresh too, so a result never outlives the code that
        made it. A change to another class, such as a model or a service, doesn't: expire its tags in your deploy, or
        flush the cache.
    </p>

    <h2 id="server-methods">Caching a #[Server] method</h2>
    <p>
        A <code>#[Server]</code> method that loads data, such as a lookup or a search, can be kept the same way.
        Nitro keeps what it did: the properties it changed and the value it returned. The next call with the same
        arguments and the same state does the same again, without running the method.
    </p>

    <x-docs.code src="cached-server.php" highlight="9" runs="server" />

    <p>
        By default, a result is kept by the method's arguments and the whole state. Any property that changed since,
        even one the method never reads, makes it a new result. <code>by</code> names the properties the result
        really depends on: here, <code>inCategory('laravel')</code> is found again whatever else the visitor changed,
        as long as <code>$status</code> is the same. <code>by: []</code> keeps it by its arguments alone.
    </p>

    @php
        $kept = [
            ['Middleware, `boot()`, `hydrate()`', 'Run as usual'],
            ['`#[Validate]` rules on the properties the browser changed', 'Checked as usual, before the cache is asked'],
            ['The method\'s body', 'Skipped: the properties it changed are set, and its value is returned'],
            ['`$this->dispatch()`, `redirect()`, `js()`, `Nitro::flash()` in the method', 'Skipped with the body'],
            ['A check in the method, such as `Gate::authorize()`', 'Skipped with the body'],
        ];
    @endphp
    <x-docs.table :columns="['On a cache hit', '']" :rows="$kept" />

    <x-docs.callout type="warning" title="Only cache methods that read">
        <p>A method that saves, sends mail or charges a card must run every time, so it is never <code>#[Cached]</code>. Cache the methods that only load data, and put what must be checked on every call in middleware, <code>boot()</code> or <code>#[Validate]</code> rules, which still run.</p>
    </x-docs.callout>

    <h2 id="per-user">One result for each user</h2>
    <p>
        A result is shared by every visitor whose request has the same inputs. That is right for a report everyone
        sees the same, and wrong for anything that depends on who is signed in. Add <code>perUser: true</code>,
        and each signed-in user gets a result of their own, with one more for guests:
    </p>

    <x-docs.code src="cached-per-user.php" highlight="1" runs="server" />

    <x-docs.callout type="warning" title="auth() in a cached method needs perUser">
        <p>Without <code>perUser</code>, the first user's result is the one everyone gets. If a cached method reads <code>auth()</code>, the session or anything else about the visitor that isn't in its arguments or state, add <code>perUser: true</code>, or don't cache it.</p>
    </x-docs.callout>

    <h2 id="options">The options</h2>

    @php
        $options = [
            ['`seconds` (first argument)', '`60`', 'How long a result is kept. At least 1'],
            ['`tags`', '`[]`', 'The tags `Nitro::expire()` forgets it by'],
            ['`perUser`', '`false`', 'One result for each signed-in user, and one for guests'],
            ['`by`', 'the whole state', 'The properties the result depends on (`#[Server]` methods and `mount()` alike). `[]` for none'],
        ];
    @endphp
    <x-docs.table :columns="['Option', 'Default', '']" :rows="$options" />

    <p>
        Results go to your application's default cache store. To use another one, set it in
        <code>config/nitro.php</code>:
    </p>

    <x-docs.code src="cached-config.php" />

    <h2 id="mistakes">What the build refuses</h2>
    <p>Each of these fails the build, naming the file and line:</p>
    <ul>
        <li><strong>A browser method.</strong> It runs where there is no cache. Mark it <code>#[Server]</code>, or load the data in <code>mount()</code>.</li>
        <li><strong>A store's method.</strong> A store is made for each request and shared by its components. Cache the <code>mount()</code> or <code>#[Server]</code> method of a component that uses it.</li>
        <li><strong>A <code>by</code> name that isn't a public property</strong>, an empty tag, or fewer than one second.</li>
    </ul>
    <p>
        A result that can't be kept, such as a property holding an object the cache can't store, is an error that
        names the method. When its inputs can't be told apart, the method simply runs every time.
        <code>$reload()</code> always runs <code>mount()</code> for fresh values, cached or not.
    </p>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">What happens during a call, and what you can trust.</x-docs.card>
        <x-docs.card href="/docs/page-data" title="Page data" icon="server" runs="server">Defer, reload and merge properties, and share data with every page.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

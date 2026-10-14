<x-docs.page
    lead="Most state is arrays or Eloquent models. You read an array with square brackets and a model with an arrow, exactly as in PHP, and both work the same in the browser and on the server."
>
    <p>
        A view runs twice: on the server with its expressions as PHP, and in the browser compiled to JavaScript. So
        the rules are PHP's rules. An array
        is read with <code>$task['title']</code>. A model, or any other object, is read with
        <code>$post-&gt;title</code>. Nitro keeps track of which values are models, so the browser reads them just
        as Laravel does.
    </p>

    <h2 id="reading">Reading arrays and models</h2>
    <p>Use the syntax that fits the value:</p>

    <x-docs.code src="data-read.blade.php" lang="blade" />

    <ul>
        <li><strong>Arrays use square brackets.</strong> Nested keys work the same way, as deep as you need.</li>
        <li><strong>Models use an arrow,</strong> and so do their loaded relations. <code>$post['title']</code> also works on a model, as it does in Laravel.</li>
        <li><strong><code>?-&gt;</code> and <code>??</code></strong> handle a missing relation or key, as they do in PHP.</li>
    </ul>

    <x-docs.callout type="warning" title="An arrow on an array fails">
        <p>
            <code>$task-&gt;title</code> on an array fails with <code>Attempt to read property "title" on array</code>.
            It fails in the browser just as it fails in a Laravel view, so you see the mistake at once, not on some
            later render. Use <code>$task['title']</code> instead.
        </p>
    </x-docs.callout>

    <h2 id="arrays">Working with arrays</h2>
    <p>
        Arrays suit data that the visitor changes in the page: form rows, a cart, a draft, a list you filter. Your
        browser methods change them with the usual PHP, without a request:
    </p>

    <x-docs.code src="data-arrays.php" highlight="13,18,24" />
    <x-docs.code src="data-arrays.blade.php" lang="blade" />

    <ul>
        <li><strong>Write to any depth.</strong> <code>$this-&gt;lines[$i]['quantity']++</code> and <code>$this-&gt;lines[] = [...]</code> work in browser methods, as in PHP.</li>
        <li><strong>Bind any depth.</strong> <code>nitro:model="lines.@{{ $i }}.quantity"</code> binds an input to one row's field, on an input or on a child component's tag.</li>
        <li><strong>Use PHP's array functions.</strong> <code>array_map()</code>, <code>array_filter()</code>, <code>usort()</code>, <code>array_splice()</code> and the rest run in the browser.</li>
        <li><strong>Arrays are values.</strong> <code>$copy = $this-&gt;lines</code> makes a copy, so changing <code>$copy</code> never changes the property.</li>
        <li><strong>Keys and their order survive.</strong> An array keyed by id stays keyed by id, in its order, on the way to the browser and back.</li>
    </ul>

    <x-docs.callout type="tip" title="Validate what the browser changed">
        <p>The browser can set an array to anything. Give it <code>#[Validate]</code> rules with <code>*</code> for each row, and call <code>$this-&gt;validate()</code> before you save. Work out totals again on the server: the browser's total is a preview.</p>
    </x-docs.callout>

    <h2 id="models">Working with models</h2>
    <p>
        Models suit records that live in the database, which your <code>#[Server]</code> methods act on. Load them in
        <code>mount()</code>, with the relations the view needs:
    </p>

    <x-docs.code src="data-models.php" runs="server" highlight="9" />
    <x-docs.code src="data-models.blade.php" lang="blade" />

    <ul>
        <li><strong>The browser gets their visible attributes.</strong> Hidden attributes (<code>$hidden</code>) are never sent.</li>
        <li><strong>Load relations with <code>with()</code>.</strong> The browser can't query the database, so a relation you didn't load isn't there. Nitro loads the same relations again on every <code>#[Server]</code> call.</li>
        <li><strong>The server reads them again on every call.</strong> A model property always comes from the database, never from what the browser sends back.</li>
        <li><strong>Change them on the server.</strong> Update a record in a <code>#[Server]</code> method. The next state the browser gets has the new values.</li>
    </ul>

    <h2 id="passing">Passing them to server methods</h2>
    <p>Pass an array's id, or the model itself. A parameter typed as a model receives the record:</p>

    @php
        $passing = [
            ['`remove($task[\'id\'])`', '`remove(int $id)`', 'The id. Look the record up yourself'],
            ['`remove($post->id)`', '`remove(Post $post)`', 'The record the key names'],
            ['`remove($post)`', '`remove(Post $post)`', 'The same record: the browser sends its key'],
        ];
    @endphp
    <x-docs.table :columns="['In the view', 'The method', 'Receives']" :rows="$passing" />

    <p>
        The key comes from the browser, so authorize the record before you act on it. See
        <a href="/docs/server-methods#arguments">Passing arguments</a>.
    </p>

    <h2 id="choosing">Choosing between them</h2>
    <p>Pick by who owns the data:</p>

    @php
        $choosing = [
            ['The visitor changes it in the page', 'An array', 'Form rows, a cart, a draft, a filter'],
            ['It lives in the database and the server acts on it', 'A model or a collection', 'Posts to publish, orders to ship'],
            ['A long list the view only shows', 'An array of the fields it shows', 'Smaller state, and nothing extra sent'],
        ];
    @endphp
    <x-docs.table :columns="['When', 'Use', 'For example']" :rows="$choosing" />

    <p>Turning models into arrays takes one call:</p>

    <x-docs.code src="data-to-arrays.php" runs="server" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/properties" title="Properties" icon="book">Every type a property can hold, and the attributes that change how it behaves.</x-docs.card>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs to arrays with nitro:model, and validate every row.</x-docs.card>
        <x-docs.card href="/docs/server-methods" title="Server methods" icon="server" runs="server">Receive models and act on them on the server.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

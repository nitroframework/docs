<x-docs.page
    lead="Nitro is a Composer package for Laravel 13. Install it, give your app a layout with two directives, and check it works with a page of a few lines."
>
    <h2 id="install">Installing Nitro</h2>

    <x-docs.steps>
        <x-docs.step title="Require the package">
            <p>Install Nitro with Composer, in a Laravel 13 application:</p>
            <x-docs.code src="install.sh" lang="sh" />
            <p>
                Laravel finds Nitro by itself: there is no service provider to register and no configuration file to
                publish. Nitro's endpoint, <code>/_nitro</code>, is ready.
            </p>
        </x-docs.step>

        <x-docs.step title="Create your layout">
            <p>
                A fresh Laravel app has no layout yet, so create this one. Pages render inside it unless they name
                another (see <a nitro:navigate href="/docs/pages#layouts">Choosing a layout</a>). If your app already
                has a layout, from a starter kit for example, add the two highlighted lines to it instead.
            </p>
            <x-docs.code src="layout.blade.php" lang="blade" file="resources/views/components/layouts/app.blade.php" highlight="6,11" />
            <ul>
                <li><strong><code>@@nitroHead</code></strong>, in the <code>&lt;head&gt;</code>, prints the page's <code>&lt;title&gt;</code> and the tags search engines and link previews read (see <a nitro:navigate href="/docs/head">The page's head</a>).</li>
                <li><strong><code>@@nitroScripts</code></strong>, just before <code>&lt;/body&gt;</code>, loads Nitro in the browser with each component's state. It is what makes the page come alive.</li>
            </ul>
            <x-docs.callout type="warning" title="Nothing happens when you click?">
                <p>Without <code>@@nitroScripts</code>, the page still shows, because the server rendered it, but nothing in it responds and no error appears. Check that the layout has it, and that the page uses that layout.</p>
            </x-docs.callout>
        </x-docs.step>

        <x-docs.step title="Check that it works">
            <p>Create a page: a class, its view, and a route.</p>
            <x-docs.code src="install-check-page.php" file="app/Nitro/Pages/Hello.php" />
            <x-docs.code src="install-check-view.blade.php" lang="blade" file="resources/views/nitro/pages/hello.blade.php" />
            <x-docs.code src="install-check-route.php" file="routes/web.php" />
            <p>
                Open <code>/hello</code> and click the button. The number goes up without a reload, and the browser's
                Network tab shows no request: <code>increment()</code> ran in the browser, compiled from your PHP. The
                first visit after you change a component takes a moment longer, while Nitro compiles it.
            </p>
        </x-docs.step>

        <x-docs.step title="Install esbuild, for production">
            <p>
                In development, Nitro needs nothing more: it serves the code it compiles unminified. For production,
                <code>php artisan nitro:build</code> minifies it with esbuild, which runs on Node. Install it in your
                app:
            </p>
            <x-docs.code src="esbuild.sh" lang="sh" />
            <p>
                Without Node or esbuild, <code>nitro:build</code> stops with a message that says which one is missing.
                If Node isn't on your <code>PATH</code>, set <code>NITRO_NODE</code> in <code>.env</code> to its
                binary.
            </p>
        </x-docs.step>

        <x-docs.step title="Publish the configuration (optional)">
            <p>Nitro works without a configuration file. When you want to change a default, publish <code>config/nitro.php</code>, and keep only what you change:</p>
            <x-docs.code src="publish-config.sh" lang="sh" />
        </x-docs.step>
    </x-docs.steps>

    <h2 id="where-files-go">Where your files go</h2>
    <p>
        Nitro has two kinds of classes. <strong>Components</strong> are parts of a page that you place in a view.
        <strong>Pages</strong> are whole screens, with their own route, layout and title.
    </p>

    <x-docs.file-tree tree="
app/
  Nitro/
    Components/          # placed in views as tags
      * Counter.php
    Pages/               # routed with Route::nitro()
resources/
  views/
    nitro/
      components/
        * counter.blade.php
      pages/
" />

    @php
        $kinds = [
            ['Class', '`app/Nitro/Components`', '`app/Nitro/Pages`'],
            ['View', '`resources/views/nitro/components`', '`resources/views/nitro/pages`'],
            ['Name', '`posts.table` for `Posts\Table`', '`pages::posts.index` for `Posts\Index`'],
            ['Used', 'placed in a view: `<'.'nitro:posts.table />`', 'routed: `Route::nitro()`'],
            ['Layout and title', 'no', '`#[Layout]`, `#[Title]`'],
        ];
    @endphp
    <x-docs.table :columns="['', 'Components', 'Pages']" :rows="$kinds" />

    <p>You can change these directories, namespaces and view paths in <code>config/nitro.php</code>.</p>

    <h2 id="production">Preparing for production</h2>
    <p>
        During development, Nitro compiles a component on the first request after you change it. When you
        deploy, build everything ahead of time instead. The build compiles every component, minifies it, and
        publishes the files to <code>public/nitro</code>.
    </p>

    <x-docs.code src="build.sh" lang="sh" />

    <x-docs.callout type="warning" title="Run it on every deploy">
        <p><code>php artisan optimize</code> doesn't run <code>nitro:build</code>, so add it to your deploy script. Also add <code>/public/nitro</code> to <code>.gitignore</code>.</p>
    </x-docs.callout>

    <h2 id="livewire">Using Nitro next to Livewire</h2>
    <p>
        Nitro and Livewire can run in the same application, and even on the same page. Nitro's tags,
        attributes, scripts and endpoints all use the <code>nitro:</code> prefix, so they never clash. This
        means you can move to Nitro one component at a time.
    </p>

    <x-docs.cards>
        <x-docs.card href="/docs/quickstart" title="Quickstart" icon="arrow">Build your first component.</x-docs.card>
        <x-docs.card href="/docs/configuration" title="Configuration" icon="book">See every option in config/nitro.php.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

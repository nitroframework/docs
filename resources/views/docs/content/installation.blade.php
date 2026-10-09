<x-docs.page
    lead="Nitro is a Composer package. Once you have installed it and added two directives to your layout, your first component is just one class and one view away."
>
    <h2 id="install">Installing Nitro</h2>

    <x-docs.steps>
        <x-docs.step title="Require the package">
            <p>Install Nitro with Composer, in a Laravel 13 application:</p>
            <x-docs.code src="install.sh" lang="sh" />
        </x-docs.step>

        <x-docs.step title="Install esbuild">
            <p>Nitro uses esbuild to minify the code it compiles:</p>
            <x-docs.code src="esbuild.sh" lang="sh" />
        </x-docs.step>

        <x-docs.step title="Add Nitro to your layout">
            <p>Add <code>@@nitroHead</code> to the <code>&lt;head&gt;</code> of your layout, and <code>@@nitroScripts</code> just before <code>&lt;/body&gt;</code>:</p>
            <x-docs.code src="layout.blade.php" lang="blade" file="resources/views/components/layouts/app.blade.php" highlight="3,8" />
        </x-docs.step>

        <x-docs.step title="Publish the configuration (optional)">
            <p>Nitro works without a configuration file. When you want to change a default, publish <code>config/nitro.php</code>:</p>
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
            ['Name', '`students.table` for `Students\Table`', '`pages::students.index` for `Students\Index`'],
            ['Used', 'placed in a view: `<'.'nitro:students.table />`', 'routed: `Route::nitro()`'],
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

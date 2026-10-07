<x-docs.page
    lead="Fusion works without any configuration. To change a default, publish config/fusion.php, where you set the endpoint, where components live, how state is signed, uploads, builds and rendering."
>
    <p>To publish the configuration files, run:</p>

    <x-docs.code src="config-publish.sh" lang="sh" />
    <p>This publishes <code>config/fusion.php</code>, and <code>config/nprogress.php</code> for the progress bar.</p>

    <h2 id="fusion">config/fusion.php</h2>

    @php
        $keys = [
            ['`endpoint`', '`/_fusion`', 'The URL prefix for `#[Server]` calls, uploads and assets (`FUSION_ENDPOINT`)'],
            ['`middleware`', '`[\'web\']`', 'The middleware the endpoint runs'],
            ['`components`', '`App\Fusion\Components`', 'The namespace, path and view path of components'],
            ['`pages`', '`App\Fusion\Pages`', 'The namespace, path and view path of pages'],
            ['`stores`', '`App\Fusion\Stores`', 'The namespace and path of stores'],
            ['`layout`', '`components.layouts.app`', 'The layout of pages without `#[Layout]`'],
            ['`head`', '`\'%s\'`', 'The defaults of `@fusionHead`: the title format, the description and the link-preview image'],
            ['`persistent_middleware`', 'auth, can, verified, ...', 'The page middleware checked again on each `#[Server]` call'],
            ['`max_payload`', '1 MB', 'The largest `#[Server]` call accepted'],
            ['`state.bind_to_session`', '`true`', 'Also sign state with the session\'s secret, so it is only valid in its own session'],
            ['`state.lifetime`', '`null`', 'How long a snapshot stays valid, in seconds. With `null`, as long as its session'],
            ['`uploads`', '', '`directory`, `rules`, `max_files` and `throttle`'],
            ['`public_config`', '`[\'app.name\']`', 'The config keys `config()` may read in the browser. Their values are public'],
            ['`compiled`', '`storage/framework/fusion`', 'Where compiled files are written'],
            ['`static`', '`fusion`', 'The directory in `public/` the build is published to'],
            ['`build.obfuscate`', '`true`', 'Whether builds are obfuscated (`FUSION_OBFUSCATE`)'],
            ['`minify_on_change`', '`true`', 'Whether to minify when recompiling during development (`FUSION_MINIFY_ON_CHANGE`)'],
            ['`rendering`', '`\'clone\'`', 'How the browser creates elements: `\'clone\'` or `\'create\'`'],
            ['`navigation`', '`\'data\'`', 'How a visit shows a page: `\'data\'` or `\'markup\'`. A page can choose with `#[Navigate]`, which also takes `\'client\'`'],
            ['`attributes`', '`[]`', 'Your own `fusion:` attributes, each run by a `Fusion.directive()`'],
            ['`views`', 'Vue, React, Solid', 'The engines for views written in a JavaScript framework: each one\'s `adapter`, the `path`s its views are in and their `extensions`'],
            ['`ssr`', 'off', 'Server rendering for those views: `enabled` (`FUSION_SSR`), the render service\'s `url`, a `timeout` and the `bundle` `fusion:ssr` runs'],
            ['`features`', '`[]`', 'Classes that run around every component on the server'],
            ['`esbuild`', '', 'The Node binary (`FUSION_NODE`) and where esbuild is installed'],
        ];
    @endphp
    <x-docs.table :columns="['Key', 'Default', 'Description']" :rows="$keys" />

    <p>Some options have a page of their own, with all the details:</p>
    <ul>
        <li><a href="/docs/head"><code>head</code></a>: titles, descriptions and link previews.</li>
        <li><a href="/docs/uploads"><code>uploads</code></a>: the rules, the number of files and the throttle.</li>
        <li><a href="/docs/navigation"><code>navigation</code></a>: data first or markup first.</li>
        <li><a href="/docs/rendering"><code>rendering</code></a>: cloning or creating elements.</li>
        <li><a href="/docs/security#state"><code>state</code></a>: sessions and lifetimes.</li>
        <li><a href="/docs/extending#attributes"><code>attributes</code></a>: your own <code>fusion:</code> attributes.</li>
        <li><a href="/docs/extending#features"><code>features</code></a>: code that runs around every component on the server.</li>
    </ul>

    <h2 id="progress-bar">config/nprogress.php</h2>
    <p>
        This file configures the progress bar shown while a visit loads. You can choose whether it shows at all
        (<code>show</code>), whether it also shows during <code>#[Server]</code> calls (<code>server_calls</code>),
        how long a visit must take before it appears (<code>delay</code>), and the shortest time it runs once
        shown (<code>minimum_duration</code>). You can also set its colour, height, speed and fade. These settings
        live only in this file.
    </p>
    <p>
        To use a different progress bar, set <code>show</code> to <code>false</code>. Then start your own bar on the
        <code>fusion:navigating</code> event and finish it on <code>fusion:navigated</code>.
    </p>

    <x-docs.callout type="tip" title="After changing configuration">
        <p>On Nitro, configuration and routes are cached. Run <code>php artisan nitro:optimize</code> after you change them or your <code>.env</code> file.</p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/testing" title="Testing" icon="book">Test pages and their state, and test methods as plain PHP.</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server">Learn what signed state protects, and what it doesn't.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

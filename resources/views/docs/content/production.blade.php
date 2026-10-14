<x-docs.page
    lead="In development, Nitro compiles a component on the first request after you change it. For production, run nitro:build to compile everything ahead of time, minify it and publish it, so the web server can send it without PHP."
>
    <p>To build your components for production, run:</p>

    <x-docs.code src="build.sh" lang="sh" />

    <h2 id="what-it-does">What a build does</h2>
    <x-docs.steps>
        <x-docs.step title="Compiles">
            <p>The build compiles every component, page and store, and minifies them with esbuild. It shows each step and how long it took, and <code>-v</code> lists the components. Chunks that haven't changed come from a cache.</p>
        </x-docs.step>
        <x-docs.step title="Publishes">
            <p>
                The build publishes the files to <code>public/nitro</code>. <code>@@nitroScripts</code> links to them
                through <code>asset()</code>, so <code>ASSET_URL</code> and a CDN work as usual. Each file name contains a
                version, so browsers can cache the files for a year
                (<code>Cache-Control: public, max-age=31536000, immutable</code>).
            </p>
        </x-docs.step>
        <x-docs.step title="Obfuscates">
            <p>
                When <code>nitro.build.obfuscate</code> is on (the default), methods, properties, pages and components
                go by aliases derived from <code>APP_KEY</code>. The aliases are used in the bundle, in the page and in
                what the browser sends, and the server translates them back. Your PHP, views and tests keep using the
                real names.
            </p>
        </x-docs.step>
    </x-docs.steps>

    <p>The build is generated, so keep it out of git:</p>
    <x-docs.code src="production-gitignore.txt" lang="text" file=".gitignore" />

    <h2 id="deploying">Deploying</h2>
    <p>
        <code>php artisan optimize</code> doesn't build Nitro, so run <code>nitro:build</code> as a separate step
        when you deploy. If you change a component after a build, the <code>/_nitro</code> routes serve the
        current code until the next build. A tab still running the old bundle reloads once to pick up the new one.
    </p>
    <x-docs.code src="production-deploy.sh" lang="sh" highlight="3" />

    <p>
        Laravel's route and config caches keep what they cached: a page you route or a config value you change
        after <code>php artisan optimize</code> is missing until you run it again. Nitro checks for that on every
        request. During development (<code>APP_DEBUG=true</code>) you get an error page naming the file that
        changed and the command to run. In production your app keeps working as cached, and the log gets one
        warning telling you to run <code>php artisan optimize</code>.
    </p>
    <p>To remove the compiled files, run <code>php artisan nitro:clear</code>.</p>

    <h2 id="names">Writing names out in full</h2>
    <p>
        Nitro can only alias names that are written out in full. Write property and key names out, rather than
        building them from variables:
    </p>
    <x-docs.code src="production-names.blade.php" lang="blade" />
    <p>
        Keys inside array properties, <code>#[Url]</code> query keys, <code>mounted()</code>, <code>destroyed()</code>
        and <code>updated()</code> always keep their names.
    </p>

    <x-docs.callout type="warning" title="The bundle is public">
        <p>
            The compiled files contain views and browser methods, never data. State, shared data and flash data
            travel with each response instead. Like any application's JavaScript, anyone can read the bundle, so keep
            secrets out of views and browser methods. Obfuscation shortens names, but it doesn't protect anything.
        </p>
    </x-docs.callout>

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/configuration" title="Configuration" icon="book">See every option in config/nitro.php.</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server">Learn what the endpoint refuses, and what the browser can see.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

<x-layouts.site title="Islands · Nitro">
    <main class="mx-auto max-w-3xl px-6 py-14 lg:px-8">
        <a nitro:navigate href="/docs/islands" class="text-sm font-medium text-violet-600 dark:text-violet-400">← Islands</a>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-800 dark:text-zinc-200">Islands, in a plain Blade page</h1>
        <p class="mt-3 text-zinc-600 dark:text-zinc-400">
            This page is a plain Blade view, not a Nitro page. Each component on it is an island that starts on
            its own, and the label beside each one shows whether it is live yet.
        </p>

        <div class="mt-10 space-y-8">
            <section class="island">
                <h2 class="island-title">nitro:hydrate.interaction <span class="island-state"></span></h2>
                <p class="island-note">Starts on the first click, key press or focus inside it. Nitro replays the click once it is live.</p>
                <nitro:counter nitro:hydrate.interaction />
            </section>

            <section class="island">
                <h2 class="island-title">nitro:hydrate.idle <span class="island-state"></span></h2>
                <p class="island-note">Starts when the browser has nothing else to do, just after the page loads.</p>
                <nitro:contacts nitro:hydrate.idle />
            </section>

            <section class="island static">
                <h2 class="island-title">nitro:static <span class="island-state"></span></h2>
                <p class="island-note">Never starts. It stays the server's HTML, with no state sent, so its buttons do nothing.</p>
                <nitro:faq nitro:static />
            </section>

            <div class="h-[60vh] rounded-xl border border-dashed border-zinc-300 p-4 text-sm text-zinc-400 dark:border-white/10">Scroll down. The next island starts when it comes into view.</div>

            <section class="island">
                <h2 class="island-title">nitro:hydrate.visible <span class="island-state"></span></h2>
                <p class="island-note">Started when it came into view.</p>
                <nitro:shortcuts nitro:hydrate.visible />
            </section>
        </div>
    </main>
</x-layouts.site>

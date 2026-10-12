<x-docs.page
    lead="One blog, five frameworks on one page, composed micro-frontend style: a Svelte form, a Vue list, React activity, Solid numbers and the latest post in Blade, each its own app, talking only through events."
>
    <x-docs.example component="blog.together" title="Five frameworks, one page" source="#the-page" />

    <p>
        Publish, edit or delete a post, and watch the other cards follow. Every card changes at once, with no
        request: the events travel in the browser.
    </p>

    <h2 id="the-page">The page</h2>
    <p>
        Blade composes the page: each card places one component, and each component has a view in a different
        framework. The form and the list are the ones from <a nitro:navigate href="/docs/examples-svelte">Svelte</a>
        and <a nitro:navigate href="/docs/examples-vue">Vue</a> blogs, unchanged.
    </p>
    <x-docs.code src="app/Nitro/Components/Blog/Together.php" file="app/Nitro/Components/Blog/Together.php" />
    <x-docs.code src="resources/views/nitro/components/blog/together.blade.php" lang="blade" file="resources/views/nitro/components/blog/together.blade.php" />

    <h2 id="events">Events across frameworks</h2>
    <p>
        An event is sent by a component's PHP and heard by another's, whatever their views are written in. The
        listeners run in the browser, so every card changes the moment the event arrives.
    </p>
    @php
        $events = [
            ['`edit-post`', 'the Vue list', 'the Svelte form, React activity'],
            ['`post-saved`', 'the Svelte form', 'the Vue list, React activity, Solid numbers, the latest post'],
            ['`post-deleted`', 'the Vue list', 'the Svelte form, React activity, Solid numbers, the latest post'],
        ];
    @endphp
    <x-docs.table :columns="['Event', 'Sent by', 'Heard by']" :rows="$events" />

    <h3 id="activity">Activity, in React</h3>
    <p>It only listens: each event adds a line.</p>
    <x-docs.code src="app/Nitro/Components/Blog/React/Activity.php" file="app/Nitro/Components/Blog/React/Activity.php" runs="browser" />
    <x-docs.code src="resources/views/react/blog/activity.jsx" lang="jsx" file="resources/views/react/blog/activity.jsx" />

    <h3 id="numbers">Numbers, in Solid</h3>
    <p>It counts each post's words once, from the server, and keeps the count up to date from the events.</p>
    <x-docs.code src="app/Nitro/Components/Blog/Solid/Stats.php" file="app/Nitro/Components/Blog/Solid/Stats.php" runs="both" />
    <x-docs.code src="resources/views/solid/blog/stats.jsx" lang="jsx" file="resources/views/solid/blog/stats.jsx" />

    <h3 id="latest">The latest post, in Blade</h3>
    <p>It shows the newest post, and follows the form and the list as they publish, change and delete.</p>
    <x-docs.code src="app/Nitro/Components/Blog/Blade/Latest.php" file="app/Nitro/Components/Blog/Blade/Latest.php" runs="both" />
    <x-docs.code src="resources/views/nitro/components/blog/blade/latest.blade.php" lang="blade" file="resources/views/nitro/components/blog/blade/latest.blade.php" />

    <p>
        Events reach the components on one page. To reach other tabs or other people, broadcast with Laravel
        (Reverb or Pusher) and listen with <code>#[On('echo:...')]</code>: see
        <a nitro:navigate href="/docs/events">Events</a>.
    </p>
</x-docs.page>

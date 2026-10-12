<x-docs.page
    lead="One blog, five frameworks on one page: a Svelte form, a Vue list, React activity, Solid numbers and a Blade card that hears Reverb. None of them knows the others are there."
>
    <x-docs.example component="blog.together" title="Five frameworks, one page" source="#the-page" />

    <p>
        Publish, edit or delete a post, and watch the other cards follow. Then open this page in a second tab and
        publish there: the <strong>Live</strong> card in this tab hears it through Reverb.
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
            ['`post-saved`', 'the Svelte form', 'the Vue list, React activity, Solid numbers'],
            ['`post-deleted`', 'the Vue list', 'the Svelte form, React activity, Solid numbers'],
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

    <h2 id="reverb">Live with Reverb</h2>
    <p>
        Events reach the components on one page. To reach the reader's other tabs, the server broadcasts:
        <code>Posts::save()</code> sends <code>PostPublished</code> through Reverb, and the Live card listens with
        <code>#[On('echo:...')]</code>. Its method runs in the browser with the event's data, so the card updates
        without a request.
    </p>
    <x-docs.code src="app/Nitro/Components/Blog/Blade/Live.php" file="app/Nitro/Components/Blog/Blade/Live.php" runs="browser" />
    <x-docs.code src="resources/views/nitro/components/blog/blade/live.blade.php" lang="blade" file="resources/views/nitro/components/blog/blade/live.blade.php" />
    <x-docs.code src="app/Events/PostPublished.php" file="app/Events/PostPublished.php" />

    <p>
        The channel is the reader's own: <code>{channel}</code> in the listener is the component's
        <code>#[Locked]</code> <code>$channel</code>, a random name kept in the reader's session, so no one else
        hears their posts. In your app, a private channel that Laravel authorizes does the same for signed-in users
        (<code>echo-private:...</code>). Echo is your app's own, set up as Laravel's broadcasting docs describe; see
        <a nitro:navigate href="/docs/events">Events</a> for every kind of channel.
    </p>
</x-docs.page>

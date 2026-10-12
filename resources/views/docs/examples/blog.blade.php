{{-- A framework's blog example (examples-blade, -vue, ...): the live blog, then each of its files as they run. --}}
@php
    $frameworks = [
        'blade' => ['name' => 'Blade', 'lang' => 'blade', 'view' => 'resources/views/nitro/components/blog/blade/%s.blade.php'],
        'vue' => ['name' => 'Vue', 'lang' => 'vue', 'view' => 'resources/views/vue/blog/%s.vue'],
        'react' => ['name' => 'React', 'lang' => 'jsx', 'view' => 'resources/views/react/blog/%s.jsx'],
        'solid' => ['name' => 'Solid', 'lang' => 'jsx', 'view' => 'resources/views/solid/blog/%s.jsx'],
        'svelte' => ['name' => 'Svelte', 'lang' => 'svelte', 'view' => 'resources/views/svelte/blog/%s.svelte'],
    ];
    ['name' => $name, 'lang' => $lang, 'view' => $view] = $frameworks[$framework];
    $folder = ucfirst($framework);
    $class = fn (string $component) => "app/Nitro/Components/Blog/{$folder}/{$component}.php";
@endphp

<x-docs.example :component="'blog.'.$framework.'.blog'" :title="'A blog in '.$name" source="#the-form" />

<p>
    Write a post, search the list, read, edit and delete. The posts are yours alone: they live in your session,
    so try anything. A blog in your app would keep them in the database; nothing else would change.
</p>

<ul>
    <li><strong>Searching</strong>, reading more, the word count and the checks on the form run in your browser, as you type.</li>
    <li><strong>Publishing, updating and deleting</strong> go to the server, which keeps the posts.</li>
    <li>The form and the list are <strong>two components</strong>. They don't know about each other: they talk through events.</li>
</ul>

<h2 id="the-blog">The blog</h2>
<p>
    @if ($framework === 'blade')
        A Blade component that places the form, and the list below it.
    @else
        A Blade component that places the form, and the list below it. Each of them is a component with a
        {{ $name }} view; a {{ $name }} view can't place other components inside itself, so Blade composes them.
    @endif
</p>
<x-docs.code :src="$class('Blog')" :file="$class('Blog')" />
<x-docs.code :src="'resources/views/nitro/components/blog/'.$framework.'/blog.blade.php'" lang="blade" :file="'resources/views/nitro/components/blog/'.$framework.'/blog.blade.php'" />

<h2 id="the-form">The form</h2>
<p>
    One form writes new posts and edits old ones: <code>postId</code> says which. The rules on
    <code>title</code> and <code>body</code> are checked as you type, and again on the server when you publish.
    Once the post is saved, <code>post-saved</code> tells the list.
</p>
<x-docs.code :src="$class('PostForm')" :file="$class('PostForm')" runs="both" />
<x-docs.code :src="sprintf($view, 'post-form')" :lang="$lang" :file="sprintf($view, 'post-form')" />

<h2 id="the-list">The list</h2>
<p>
    The list filters itself as you type in the search box: <code>results</code> is worked out again in the
    browser whenever <code>search</code> or <code>posts</code> change. Edit sends the post to the form with
    <code>edit-post</code>; delete asks once more, then removes the post on the server and says
    <code>post-deleted</code>.
</p>
<x-docs.code :src="$class('PostIndex')" :file="$class('PostIndex')" runs="both" />
<x-docs.code :src="sprintf($view, 'post-index')" :lang="$lang" :file="sprintf($view, 'post-index')" />

<h2 id="events">How they talk</h2>
@php
    $events = [
        ['`edit-post`', 'the list', 'the form', 'In the browser, at once'],
        ['`post-saved`', 'the form', 'the list', 'With the server\'s answer, once the post is saved'],
        ['`post-deleted`', 'the list', 'the form (if it was editing that post)', 'With the server\'s answer'],
    ];
@endphp
<x-docs.table :columns="['Event', 'Sent by', 'Heard by', 'When']" :rows="$events" />
<p>
    Every listener runs in the browser, so the other component changes the moment the event arrives. See
    <a nitro:navigate href="/docs/events">Events</a>.
</p>

<h2 id="the-posts">The posts</h2>
<p>
    Both components ask one small class for the posts. Here it keeps them in your session; in your app it would
    be your <code>Post</code> model.
</p>
<x-docs.code src="app/Blog/Posts.php" file="app/Blog/Posts.php" />

<h2 id="other-frameworks">The same blog, other views</h2>
<p>
    The PHP is the same on every page of this section; only the views change:
    {!! collect($frameworks)->except($framework)->map(fn (array $other, string $key) => '<a nitro:navigate href="/docs/examples-'.$key.'">'.e($other['name']).'</a>')->implode(', ') !!}.
    To see components in all five working together, with Reverb, see
    <a nitro:navigate href="/docs/examples-together">All together</a>.
</p>

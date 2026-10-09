{{-- resources/views/nitro/pages/editor.blade.php: one page, three engines --}}
<x-layouts.app>
    <h1>Editor</h1>

    <div class="grid grid-cols-3 gap-6">
        <nitro:vue.post-list />                        {{-- picks a post, publishes it --}}
        <nitro:react.post-preview />                   {{-- hears both, and shows the post --}}
        <nitro:posts.recent :limit="10" />             {{-- a Blade view, hearing the same events --}}
    </div>
</x-layouts.app>

<div class="own-styles w-full space-y-4">
    <x-blog.card title="The blog in numbers" framework="Solid" note="hears post-saved, post-deleted">
        <nitro:blog.solid.stats />
    </x-blog.card>

    <x-blog.card title="Write" framework="Svelte" note="sends post-saved · hears edit-post">
        <nitro:blog.svelte.post-form />
    </x-blog.card>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-blog.card title="On this page" framework="React" note="hears every event">
            <nitro:blog.react.activity />
        </x-blog.card>

        <x-blog.card title="Latest post" framework="Blade" note="hears post-saved, post-deleted">
            <nitro:blog.blade.latest />
        </x-blog.card>
    </div>

    <x-blog.card title="Read" framework="Vue" note="sends edit-post, post-deleted">
        <nitro:blog.vue.post-index />
    </x-blog.card>
</div>

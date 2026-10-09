<nitro:card>
    <p>{{ $post['title'] }} has {{ $post['comments'] }} comments.</p>

    <nitro:slot name="footer">
        <button nitro:click="publish($post['id'])">Publish</button>
    </nitro:slot>
</nitro:card>

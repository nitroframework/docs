<x-docs.page
    lead="When you bind a file input with fusion:model, the file uploads as soon as the visitor chooses it. The component holds a signed reference to it, the view can preview it, and a #[Server] method validates and stores it."
>
    <p>
        As soon as the visitor chooses a file, it is sent to the server, where it waits in a private directory.
        The property becomes an <code>Upload</code>. The browser can show the file's name, its size and a preview,
        and a <code>#[Server]</code> method validates and stores it like any uploaded file in Laravel.
    </p>

    <x-docs.example component="photo-check" title="An upload, checked on the server" source="#the-component" />

    <h2 id="the-component">The component</h2>
    <x-docs.pair class="app/Fusion/Components/PhotoCheck.php" view="resources/views/fusion/components/photo-check.blade.php" component="photo-check" />

    <x-docs.callout type="note" title="Checked, not kept, for this demo">
        <p>So that any visitor can try it, the example reads the photo's size on the server and keeps nothing. These docs accept images up to 2 MB. Your app would store the photo with <code>$this-&gt;photo-&gt;store('photos', 'public')</code>.</p>
    </x-docs.callout>

    <h2 id="one-or-several">Accepting one file or several</h2>
    <p>
        A <code>?Upload</code> property takes one file. To take the files of an input with <code>multiple</code>,
        use an array property marked <code>#[Uploads]</code>:
    </p>

    <x-docs.code src="uploads-many.php" runs="server" highlight="4,6,7" />

    <p>
        <code>Upload</code> is Laravel's <code>UploadedFile</code>, so validation rules such as
        <code>image</code>, <code>mimes</code> and <code>max</code>, and <code>store()</code>, all work as usual. You
        can use these methods in the view, on the server and in the browser:
    </p>

    @php
        $methods = [
            ['`temporaryUrl()`', 'A URL to preview the file, for images'],
            ['`getClientOriginalName()`', 'Its name on the visitor\'s computer'],
            ['`getClientOriginalExtension()`', 'Its extension'],
            ['`getSize()`', 'Its size, in bytes'],
            ['`getMimeType()`', 'Its type, such as `image/png`'],
        ];
    @endphp
    <x-docs.table :columns="['Method', 'Gives']" :rows="$methods" />

    <h2 id="while-uploading">Showing progress while it uploads</h2>
    <p>
        <code>fusion:loading fusion:target="photo"</code> shows an element while the file is on its way, just as it
        does for a <code>#[Server]</code> call. The input also fires events that report the progress:
    </p>

    <x-docs.code src="uploads-events.js" lang="js" />

    <h2 id="what-is-checked">What Fusion checks</h2>
    <ul>
        <li><strong>As each file arrives</strong>, Fusion checks it against <code>fusion.uploads.rules</code>. If a rule refuses the file, the property gets an <code>$errors</code> message and the upload stops there.</li>
        <li><strong>In your method</strong>, you check your own rules with <code>$this-&gt;validate()</code>.</li>
        <li><strong>The reference</strong> the browser holds is signed, and it only works in its own session. Fusion refuses a made-up or changed reference. Only <code>Upload</code> and <code>#[Uploads]</code> properties accept files.</li>
        <li><strong>Leftover uploads</strong> that no component stored are removed after a day.</li>
    </ul>

    <x-docs.code src="uploads-config.php" />

    <h2 id="next-steps">Next steps</h2>
    <x-docs.cards>
        <x-docs.card href="/docs/forms" title="Forms and validation" icon="book">Bind inputs with fusion:model, and validate them with #[Validate].</x-docs.card>
        <x-docs.card href="/docs/security" title="Security" icon="server" runs="server">Learn what the endpoint refuses, uploads included.</x-docs.card>
    </x-docs.cards>
</x-docs.page>

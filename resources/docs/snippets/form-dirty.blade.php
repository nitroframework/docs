<form nitro:submit="save">
    <input nitro:model="title" nitro:dirty.class="border-amber-500" nitro:target="title">
    <textarea nitro:model="body"></textarea>

    <p nitro:dirty>You have unsaved changes.</p>
    <p nitro:dirty.remove>All changes saved.</p>
    <button>Save</button>
</form>

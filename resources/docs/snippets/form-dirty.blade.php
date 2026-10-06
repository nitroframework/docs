<form fusion:submit="save">
    <input fusion:model="title" fusion:dirty.class="border-amber-500" fusion:target="title">
    <textarea fusion:model="body"></textarea>

    <p fusion:dirty>You have unsaved changes.</p>
    <p fusion:dirty.remove>All changes saved.</p>
    <button>Save</button>
</form>

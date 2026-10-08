export default function PostEditor({ title, body, tags, words, savedAt, set, addTag, removeTag, save, errors, unsaved }) {
    function submit(event) {
        event.preventDefault();
        save();
    }

    function addFromInput(event) {
        if (event.key !== 'Enter') return;
        event.preventDefault();
        addTag(event.target.value);
        event.target.value = '';
    }

    return (
        <form className="editor" onSubmit={submit}>
            <input value={title} onChange={(e) => set('title', e.target.value)} placeholder="Title" />
            {errors.title && <p className="error">{errors.title[0]}</p>}

            <textarea value={body} onChange={(e) => set('body', e.target.value)} rows={8} />
            <p className="muted">{words} words</p>

            <ul className="tags">
                {tags.map((tag, index) => (
                    <li key={tag}>
                        {tag} <button type="button" onClick={() => removeTag(index)}>×</button>
                    </li>
                ))}
            </ul>
            <input placeholder="Add a tag" onKeyDown={addFromInput} />

            <button disabled={save.processing}>{save.slow ? 'Saving…' : 'Save'}</button>
            {unsaved.length > 0 && <span className="muted">Unsaved changes</span>}
            {savedAt && <span className="muted">Saved at {savedAt}</span>}
        </form>
    );
}

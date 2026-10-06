import { useState } from 'react';

export default function PostEditor({ title, body, tags, words, set, addTag, save, errors, unsaved }) {
    const [tag, setTag] = useState('');
    const [said, setSaid] = useState('');

    async function submit(event) {
        event.preventDefault();
        setSaid(await save());
    }

    return (
        <form className="post-editor" onSubmit={submit}>
            <input value={title} onChange={(e) => set('title', e.target.value)} placeholder="Title" />
            {errors.title && <p className="error">{errors.title[0]}</p>}

            <textarea value={body} onChange={(e) => set('body', e.target.value)} />
            <p>{words} words</p>

            {tags.map((name) => <span key={name} className="tag">{name}</span>)}
            <input value={tag} onChange={(e) => setTag(e.target.value)}
                onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), addTag(tag), setTag(''))} />

            <button disabled={save.processing}>Save</button>
            {save.slow && <span>Saving…</span>}
            {unsaved.length > 0 && <span>Unsaved changes</span>}
            <p>{said}</p>
        </form>
    );
}

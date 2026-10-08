import { useEffect, useMemo, useState } from 'react';

export default function PostEditor({ title, words, set, save, errors }) {
    /** The view's own state, as in any React component. */
    const [said, setSaid] = useState('');
    const readingTime = useMemo(() => Math.max(1, Math.round(words / 200)), [words]);

    /** Props change when the component does: effects follow them like any props. */
    useEffect(() => {
        document.title = title ? `Editing: ${title}` : 'New post';
    }, [title]);

    async function submit(event) {
        event.preventDefault();
        setSaid((await save()) ?? '');
    }

    return (
        <form onSubmit={submit}>
            <input value={title} onChange={(e) => set('title', e.target.value)} />
            {errors.title && <p className="error">{errors.title[0]}</p>}
            <p>{words} words, about {readingTime} min to read</p>

            <button disabled={save.processing}>Save</button>
            <p>{said}</p>
        </form>
    );
}

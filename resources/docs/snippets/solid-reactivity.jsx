import { createEffect, createMemo, createSignal } from 'solid-js';

export default function PostEditor(props) {
    /** The view's own state, as in any Solid component. */
    const [said, setSaid] = createSignal('');

    /** props.words is tracked where it is read: the memo follows the component. */
    const readingTime = createMemo(() => Math.max(1, Math.round(props.words / 200)));

    createEffect(() => {
        document.title = props.title ? `Editing: ${props.title}` : 'New post';
    });

    async function submit(event) {
        event.preventDefault();
        setSaid((await props.save()) ?? '');
    }

    return (
        <form onSubmit={submit}>
            <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} />
            <p>{props.words} words, about {readingTime()} min to read</p>

            <button disabled={props.save.processing}>Save</button>
            <p>{said()}</p>
        </form>
    );
}

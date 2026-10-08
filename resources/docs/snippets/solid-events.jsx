import { createSignal, onCleanup, onMount, Show } from 'solid-js';

export default function PreviewBar(props) {
    const [lastSaved, setLastSaved] = createSignal(null);

    /** An event another component dispatched (without ->to()), heard in the view's own code: its values in order. */
    const heard = (event) => setLastSaved(event.detail.params[0]);
    onMount(() => window.addEventListener('post-saved', heard));
    onCleanup(() => window.removeEventListener('post-saved', heard));

    return (
        <>
            <button onClick={() => props.dispatch('preview-requested', 42)}>Preview</button>
            <Show when={lastSaved()}><p>Post {lastSaved()} was just saved.</p></Show>
        </>
    );
}

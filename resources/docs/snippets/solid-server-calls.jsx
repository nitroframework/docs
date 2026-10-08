import { createSignal, Match, Show, Switch } from 'solid-js';

export default function SaveButton(props) {
    const [notice, setNotice] = createSignal('');

    async function submit() {
        try {
            /** The method's return value; null when a rule failed (errors has the messages). */
            const said = await props.save();
            setNotice(said ?? 'Please fix the highlighted fields.');
        } catch {
            /** The request itself failed: the server's error, or no connection. save.error says why. */
            setNotice(`Not saved: ${props.save.error}`);
        }
    }

    return (
        <>
            <button disabled={props.save.processing} onClick={submit}>
                <Switch fallback="Save">
                    <Match when={props.save.slow}>Still saving…</Match>
                    <Match when={props.save.processing}>Saving</Match>
                </Switch>
            </button>
            <Show when={props.save.failed}><p class="error">{props.save.error}</p></Show>
            <p>{notice()}</p>
        </>
    );
}

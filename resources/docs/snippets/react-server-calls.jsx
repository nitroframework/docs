import { useState } from 'react';

export default function SaveButton({ save }) {
    const [notice, setNotice] = useState('');

    async function submit() {
        try {
            /** The method's return value; null when a rule failed (errors has the messages). */
            const said = await save();
            setNotice(said ?? 'Please fix the highlighted fields.');
        } catch {
            /** The request itself failed: the server's error, or no connection. save.error says why. */
            setNotice(`Not saved: ${save.error}`);
        }
    }

    return (
        <>
            <button disabled={save.processing} onClick={submit}>
                {save.slow ? 'Still saving…' : save.processing ? 'Saving' : 'Save'}
            </button>
            {save.failed && <p className="error">{save.error}</p>}
            <p>{notice}</p>
        </>
    );
}

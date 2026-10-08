import { useEffect, useState } from 'react';

export default function PreviewBar({ dispatch }) {
    const [lastSaved, setLastSaved] = useState(null);

    /** An event another component dispatched (without ->to()), heard in the view's own code: its values in order. */
    useEffect(() => {
        const heard = (event) => setLastSaved(event.detail.params[0]);
        window.addEventListener('post-saved', heard);
        return () => window.removeEventListener('post-saved', heard);
    }, []);

    return (
        <>
            <button onClick={() => dispatch('preview-requested', 42)}>Preview</button>
            {lastSaved && <p>Post {lastSaved} was just saved.</p>}
        </>
    );
}

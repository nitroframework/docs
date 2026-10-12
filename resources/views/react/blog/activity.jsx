const DOTS = {
    'edit-post': 'bg-browser-500',
    'post-saved': 'bg-emerald-500',
    'post-deleted': 'bg-red-500',
};

export default function Activity({ events, clear }) {
    if (events.length === 0) {
        return <p className="py-6 text-center text-sm text-slate-500">Nothing yet. Publish, edit or delete a post.</p>;
    }

    return (
        <div>
            <ul className="space-y-2.5">
                {events.map((event, index) => (
                    <li key={events.length - index} className="flex items-start gap-2.5 text-sm">
                        <span className={`mt-1.5 size-2 shrink-0 rounded-full ${DOTS[event.kind]}`} />
                        <span className="min-w-0 flex-1">
                            <span className="block truncate text-slate-700 dark:text-slate-300">{event.text}</span>
                            <code className="text-[11px] text-slate-400">{event.kind}</code>
                        </span>
                    </li>
                ))}
            </ul>
            <button type="button" className="mt-3 text-xs font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white" onClick={clear}>Clear</button>
        </div>
    );
}

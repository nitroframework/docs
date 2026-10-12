export default function Stats(props) {
    const figures = () => [
        { label: 'Posts', value: props.posts },
        { label: 'Words', value: props.total.toLocaleString() },
        { label: 'To read them all', value: `${props.minutes} min` },
    ];

    return (
        <dl class="grid grid-cols-3 divide-x divide-slate-200 dark:divide-white/10">
            {figures().map((figure) => (
                <div class="px-4 first:pl-0">
                    <dt class="text-xs text-slate-500">{figure.label}</dt>
                    <dd class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 tabular-nums dark:text-white">{figure.value}</dd>
                </div>
            ))}
        </dl>
    );
}

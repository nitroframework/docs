// Laravel Echo, through Reverb: the examples' live components listen with #[On('echo:...')].
// window.Echo stands in for Echo until a component listens to a channel: Echo and Pusher load
// then, so a page without a live component downloads neither. The docs listen on public channels
// only, so that is all it stands in for.
let echo = null;

function connect() {
    echo ??= Promise.all([import('laravel-echo'), import('pusher-js')]).then(([{ default: Echo }, { default: Pusher }]) => {
        window.Pusher = Pusher;
        return new Echo({
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY,
            wsHost: import.meta.env.VITE_REVERB_HOST,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    });

    return echo;
}

if (import.meta.env.VITE_REVERB_APP_KEY) {
    window.Echo = {
        channel(name) {
            const channel = {
                listen(event, callback) {
                    connect().then((echo) => echo.channel(name).listen(event, callback));
                    return channel;
                },
                stopListening(event, callback) {
                    connect().then((echo) => echo.channel(name).stopListening(event, callback));
                    return channel;
                },
            };

            return channel;
        },
    };
}

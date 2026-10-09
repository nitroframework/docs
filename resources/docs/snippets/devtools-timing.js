// The same numbers, for your own logging: every response the page has fetched.
for (const entry of performance.getEntriesByType('resource')) {
    for (const { name, duration } of entry.serverTiming) {
        console.log(entry.name, name, `${duration}ms`);   // ".../_nitro/update" "nitro" "38.4ms"
    }
}

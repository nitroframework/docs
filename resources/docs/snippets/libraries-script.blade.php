<div>
    <canvas nitro:ref="chart"></canvas>

    @nitroScript
    <script>
        const chart = new Chart($refs.chart, {
            type: 'line',
            data: { labels: $component.get('months'), datasets: [{ data: $component.get('views') }] },
        });

        const stop = $component.watch('views', (views) => {
            chart.data.datasets[0].data = views;
            chart.update();
        });

        return () => {
            stop();
            chart.destroy();
        };
    </script>
    @endNitroScript
</div>

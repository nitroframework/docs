import Chart from 'chart.js/auto';

/** The revenue chart: drawn from the component's months, and again when they change. */
export default function revenue(el, fusion) {
    const canvas = el.appendChild(document.createElement('canvas'));
    const data = () => {
        const months = fusion.get('months');

        return {
            labels: months.map((month) => month.label),
            datasets: [{ label: 'Revenue', data: months.map((month) => month.cents / 100) }],
        };
    };
    const chart = new Chart(canvas, { type: 'bar', data: data() });

    return {
        redraw() {
            chart.data = data();
            chart.update();
        },
        destroy() {
            chart.destroy();
        },
    };
}

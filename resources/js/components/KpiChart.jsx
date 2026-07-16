import React, { useRef, useEffect } from 'react';

export default function KpiChart({ labels, values }) {
    const canvasRef = useRef(null);
    const chartRef = useRef(null);

    useEffect(() => {
        let mounted = true;

        function initChart() {
            const Chart = window.Chart;
            if (!Chart) {
                setTimeout(() => { if (mounted) initChart(); }, 200);
                return;
            }

            if (chartRef.current) {
                chartRef.current.destroy();
            }

            const ctx = canvasRef.current?.getContext('2d');
            if (!ctx) return;

            const computed = getComputedStyle(document.documentElement);
            const barColor = '#3B82F6';
            const gridColor = '#E4E4E7';
            const labelColor = '#71717A';

            chartRef.current = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Favoritos',
                        data: values,
                        backgroundColor: barColor,
                        borderRadius: 4,
                        borderSkipped: false,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: 'Inter, sans-serif', size: 12 },
                                color: labelColor,
                            },
                            grid: { color: gridColor },
                        },
                        y: {
                            ticks: {
                                font: { family: 'Inter, sans-serif', size: 12 },
                                color: labelColor,
                            },
                            grid: { display: false },
                        },
                    },
                },
            });
        }

        initChart();

        return () => {
            mounted = false;
            if (chartRef.current) {
                chartRef.current.destroy();
            }
        };
    }, [labels, values]);

    return (
        <div className="w-full h-64">
            <canvas ref={canvasRef} />
        </div>
    );
}

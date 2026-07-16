import React, { useRef, useEffect } from 'react';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default function KpiChart({ labels, values }) {
    const canvasRef = useRef(null);
    const chartRef = useRef(null);

    useEffect(() => {
        if (chartRef.current) {
            chartRef.current.destroy();
        }

        const ctx = canvasRef.current?.getContext('2d');
        if (!ctx) return;

        chartRef.current = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Favoritos',
                    data: values,
                    backgroundColor: '#0077C0',
                    borderRadius: 6,
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
                        },
                        grid: { color: '#f0f0f0' },
                    },
                    y: {
                        ticks: {
                            font: { family: 'Inter, sans-serif', size: 12 },
                        },
                        grid: { display: false },
                    },
                },
            },
        });

        return () => {
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

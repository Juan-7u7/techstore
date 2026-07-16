// Componente React que renderiza una grafica de barras horizontal con Chart.js (CDN)
import React, { useRef, useEffect } from 'react';

export default function KpiChart({ labels, values }) {
    const canvasRef = useRef(null);
    const chartRef = useRef(null); // Referencia para destruir la grafica anterior al actualizar

    useEffect(() => {
        // Chart.js se carga via CDN, accesible desde window.Chart
        const Chart = window.Chart;
        if (!Chart) return;

        // Destruye la grafica anterior antes de crear una nueva (evita fugas de memoria)
        if (chartRef.current) {
            chartRef.current.destroy();
        }

        const ctx = canvasRef.current?.getContext('2d');
        if (!ctx) return;

        // Grafica horizontal: categorias en el eje Y, cantidad de favoritos en el eje X
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
                indexAxis: 'y', // Barras horizontales
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

        // Limpieza al desmontar el componente o al cambiar datos
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

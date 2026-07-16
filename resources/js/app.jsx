import { createRoot } from 'react-dom/client';
import FavoritosRecientes from './components/FavoritosRecientes';
import KpiChart from './components/KpiChart';

const contenedorFav = document.getElementById('react-favoritos');
if (contenedorFav) {
    createRoot(contenedorFav).render(<FavoritosRecientes />);
}

const contenedorChart = document.getElementById('react-chart');
if (contenedorChart) {
    const labels = JSON.parse(contenedorChart.dataset.labels || '[]');
    const values = JSON.parse(contenedorChart.dataset.values || '[]');
    createRoot(contenedorChart).render(<KpiChart labels={labels} values={values} />);
}

import { createRoot } from 'react-dom/client';
import FavoritosRecientes from './components/FavoritosRecientes';
import KpiChart from './components/KpiChart';

let rootFav = null;
let rootChart = null;

function montarReact() {
    const cFav = document.getElementById('react-favoritos');
    if (cFav) {
        if (rootFav) rootFav.unmount();
        const favoritos = JSON.parse(cFav.dataset.favoritos || '[]');
        rootFav = createRoot(cFav);
        rootFav.render(<FavoritosRecientes favoritosIniciales={favoritos} />);
    }

    const cChart = document.getElementById('react-chart');
    if (cChart) {
        if (rootChart) rootChart.unmount();
        const labels = JSON.parse(cChart.dataset.labels || '[]');
        const values = JSON.parse(cChart.dataset.values || '[]');
        rootChart = createRoot(cChart);
        rootChart.render(<KpiChart labels={labels} values={values} />);
    }
}

document.addEventListener('livewire:navigated', montarReact);
montarReact();

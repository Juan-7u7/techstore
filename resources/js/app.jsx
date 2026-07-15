import { createRoot } from 'react-dom/client';
import FavoritosRecientes from './components/FavoritosRecientes';

const contenedor = document.getElementById('react-favoritos');
if (contenedor) {
    createRoot(contenedor).render(<FavoritosRecientes />);
}

import React, { useState, useEffect } from 'react';

// Componente React que muestra los ultimos 5 favoritos del usuario
export default function FavoritosRecientes() {
    // Estado: lista de favoritos y bandera de carga
    const [favoritos, setFavoritos] = useState([]);
    const [cargando, setCargando] = useState(true);

    // Al montar el componente obtiene los favoritos via API
    useEffect(() => {
        fetch('/api/favorites', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest', // Necesario para Sanctum SPA
            },
            credentials: 'same-origin', // Envia la cookie de sesion
        })
            .then(res => res.json())
            .then(data => {
                setFavoritos(data.slice(0, 5)); // Solo los ultimos 5
                setCargando(false);
            })
            .catch(() => setCargando(false)); // Silencia errores si no hay sesion
    }, []);

    if (cargando) {
        return <p className="text-gray-500">Cargando favoritos...</p>;
    }

    if (favoritos.length === 0) {
        return <p className="text-gray-500">No tienes favoritos aún.</p>;
    }

    return (
        <div className="space-y-3">
            <h3 className="text-lg font-semibold">Tus favoritos recientes</h3>
            <ul className="divide-y divide-gray-200">
                {favoritos.map(fav => (
                    <li key={fav.id} className="py-2 flex items-center gap-3">
                        {fav.product_data?.image && (
                            <img
                                src={fav.product_data.image}
                                alt={fav.product_data.title}
                                className="w-12 h-12 object-cover rounded"
                            />
                        )}
                        <div>
                            <p className="text-sm font-medium">{fav.product_data?.title ?? 'Producto #' + fav.product_id}</p>
                            <p className="text-xs text-gray-500">
                                ${fav.product_data?.price ? Number(fav.product_data.price).toFixed(2) : ''}
                            </p>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

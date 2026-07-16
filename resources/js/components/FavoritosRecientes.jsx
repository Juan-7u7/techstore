import React from 'react';

// Componente React que muestra los ultimos 5 favoritos del usuario
// Los datos vienen del servidor (Livewire) via data-favoritos, sin fetch a la API
export default function FavoritosRecientes({ favoritosIniciales = [] }) {

    if (favoritosIniciales.length === 0) {
        return <p className="text-gray-500">No tienes favoritos aún.</p>;
    }

    return (
        <div className="space-y-3">
            <h3 className="text-lg font-semibold">Tus favoritos recientes</h3>
            <ul className="divide-y divide-gray-200">
                {favoritosIniciales.map(fav => (
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

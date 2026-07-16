import React from 'react';

export default function FavoritosRecientes({ favoritosIniciales = [] }) {
    if (favoritosIniciales.length === 0) {
        return <p className="text-sm text-muted">No tienes favoritos aún.</p>;
    }

    return (
        <div className="divide-y divide-border/60 -mx-1">
            {favoritosIniciales.map(fav => (
                <div key={fav.id} className="py-3 flex items-center gap-3">
                    {fav.product_data?.image && (
                        <img
                            src={fav.product_data.image}
                            alt={fav.product_data.title}
                            className="w-11 h-11 object-cover rounded-lg shrink-0 bg-fondo"
                        />
                    )}
                    <div className="min-w-0">
                        <p className="text-sm font-medium text-primary truncate">
                            {fav.product_data?.title ?? 'Producto #' + fav.product_id}
                        </p>
                        <p className="text-xs text-muted">
                            ${fav.product_data?.price ? Number(fav.product_data.price).toFixed(2) : ''}
                        </p>
                    </div>
                </div>
            ))}
        </div>
    );
}

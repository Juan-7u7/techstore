import React, { useState } from 'react';

function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

export default function FavoritosRecientes({ favoritosIniciales = [] }) {
    const [favoritos, setFavoritos] = useState(favoritosIniciales);

    async function quitar(fav) {
        const res = await fetch(`/favorites/${fav.product_id}/remove`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken() },
        });
        if (res.ok) {
            setFavoritos(prev => prev.filter(f => f.id !== fav.id));
        }
    }

    if (favoritos.length === 0) {
        return <p className="text-sm text-muted">No tienes favoritos aún.</p>;
    }

    return (
        <div className="divide-y divide-border/60 -mx-1">
            {favoritos.map(fav => (
                <div key={fav.id} className="py-3 flex items-center gap-3">
                    <a
                        href={`/productos/${fav.product_id}`}
                        className="flex items-center gap-3 flex-1 min-w-0 group cursor-pointer"
                    >
                        {fav.product_data?.image && (
                            <img
                                src={fav.product_data.image}
                                alt={fav.product_data.title}
                                className="w-11 h-11 object-cover rounded-lg shrink-0 bg-fondo group-hover:opacity-80 transition-opacity"
                            />
                        )}
                        <div className="min-w-0">
                            <p className="text-sm font-medium text-primary truncate group-hover:text-accent transition-colors">
                                {fav.product_data?.title ?? 'Producto #' + fav.product_id}
                            </p>
                            <p className="text-xs text-muted">
                                ${fav.product_data?.price ? Number(fav.product_data.price).toFixed(2) : ''}
                            </p>
                        </div>
                    </a>
                    <button
                        onClick={() => quitar(fav)}
                        className="shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-muted hover:text-red-500 hover:bg-red-50 transition-colors"
                        title="Quitar de favoritos"
                    >
                        <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            ))}
        </div>
    );
}

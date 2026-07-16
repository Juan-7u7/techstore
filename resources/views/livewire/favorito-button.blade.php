<div>
    @if ($modo === 'button')
        <button
            wire:click="toggleFavorito"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 w-full sm:w-auto
                {{ $esFavorito
                    ? 'bg-red-50 text-red-600 border border-red-200 hover:bg-red-100'
                    : 'bg-accent text-white hover:bg-accent/90 shadow-soft-sm' }}"
        >
            <svg class="w-4 h-4" fill="{{ $esFavorito ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            {{ $esFavorito ? 'Quitar de favoritos' : 'Agregar a favoritos' }}
        </button>
    @else
        <button
            wire:click="toggleFavorito"
            class="inline-flex items-center justify-center w-9 h-9 rounded-full transition-all duration-200
                {{ $esFavorito
                    ? 'bg-red-50 text-red-500 shadow-soft-sm hover:bg-red-100'
                    : 'bg-surface/80 text-muted hover:text-red-400 hover:bg-red-50 shadow-soft-sm' }}"
            title="{{ $esFavorito ? 'Quitar de favoritos' : 'Agregar a favoritos' }}"
        >
            <svg class="w-4.5 h-4.5" fill="{{ $esFavorito ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>
    @endif
</div>

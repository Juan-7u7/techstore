<div>
    <div class="sticky top-16 z-20 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 bg-fondo/90 backdrop-blur-md border-b border-border/30 mb-6">
        <div class="py-3 space-y-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted/60 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="busqueda"
                    wire:keyup.escape="$set('busqueda', '')"
                    placeholder="Buscar productos..."
                    class="w-full pl-10 pr-9 py-2 text-sm bg-surface border border-border/60 rounded-xl text-primary placeholder-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent/30 transition-colors"
                >
                @if ($busqueda)
                    <button wire:click="$set('busqueda', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted/50 hover:text-muted transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="overflow-x-auto scrollbar-hide flex-1 -mb-px">
                    <div class="flex gap-1 min-w-max pb-px">
                        <button
                            wire:click="filtrarPorCategoria(0)"
                            class="relative px-3 py-2 text-sm font-medium transition-colors whitespace-nowrap
                                {{ $categoriaSeleccionada === 0 ? 'text-primary' : 'text-muted hover:text-primary' }}"
                        >
                            Todas
                            @if ($categoriaSeleccionada === 0)
                                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-accent rounded-full"></span>
                            @endif
                        </button>

                        @foreach ($categorias as $categoria)
                            <button
                                wire:click="filtrarPorCategoria({{ $categoria['id'] }})"
                                class="relative px-3 py-2 text-sm font-medium transition-colors whitespace-nowrap
                                    {{ $categoriaSeleccionada === $categoria['id'] ? 'text-primary' : 'text-muted hover:text-primary' }}"
                            >
                                {{ $categoria['name'] }}
                                @if ($categoriaSeleccionada === $categoria['id'])
                                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-accent rounded-full"></span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <span class="text-xs text-muted/60 shrink-0 hidden sm:inline">
                    {{ count($productos) }} producto{{ count($productos) !== 1 ? 's' : '' }}
                </span>
            </div>
        </div>
    </div>

    <div
        wire:loading.class="opacity-40 pointer-events-none"
        class="transition-opacity duration-300"
    >
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($productos as $producto)
                <div class="card-product group">
                    <div class="relative aspect-square bg-fondo overflow-hidden">
                        <img
                            src="{{ $producto['images'][0] ?? 'https://placehold.co/400x400' }}"
                            alt="{{ $producto['title'] }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                        @auth
                            <div class="absolute top-2 right-2 z-10">
                                <livewire:favorito-button
                                    :productoId="$producto['id']"
                                    :productoData="[
                                        'title' => $producto['title'],
                                        'price' => $producto['price'],
                                        'image' => $producto['images'][0] ?? '',
                                        'category' => $producto['category']['name'] ?? '',
                                    ]"
                                    :key="'fav-' . $producto['id']"
                                />
                            </div>
                        @endauth
                    </div>

                    <div class="p-4 flex flex-col flex-1 gap-1.5">
                        <span class="text-xs text-muted uppercase tracking-wider font-medium">
                            {{ $producto['category']['name'] ?? 'General' }}
                        </span>
                        <a href="{{ route('productos.detalle', $producto['id']) }}" wire:navigate>
                            <h3 class="font-heading font-semibold text-primary leading-snug line-clamp-2 group-hover:text-accent transition-colors">
                                {{ $producto['title'] }}
                            </h3>
                        </a>
                        <p class="text-lg font-semibold text-primary mt-auto pt-2">${{ number_format($producto['price'], 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-center gap-3 mt-12">
        <button
            wire:click="paginaAnterior"
            @disabled($pagina === 0)
            class="{{ $pagina === 0 ? 'btn-pill-ghost opacity-40 cursor-not-allowed' : 'btn-pill-ghost' }}"
        >
            &larr; Anterior
        </button>

        <span class="text-sm text-muted px-3">Página {{ $pagina + 1 }}</span>

        <button
            wire:click="paginaSiguiente"
            @disabled(!$hayMas)
            class="{{ !$hayMas ? 'btn-pill-ghost opacity-40 cursor-not-allowed' : 'btn-pill-ghost' }}"
        >
            Siguiente &rarr;
        </button>
    </div>
</div>

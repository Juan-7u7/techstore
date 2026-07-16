<div>
    <div class="flex flex-wrap gap-2 mb-8">
        <button
            wire:click="filtrarPorCategoria(0)"
            class="{{ $categoriaSeleccionada === 0 ? 'btn-pill-active' : 'btn-pill-ghost' }}"
        >
            Todas
        </button>

        @foreach ($categorias as $categoria)
            <button
                wire:click="filtrarPorCategoria({{ $categoria['id'] }})"
                class="{{ $categoriaSeleccionada === $categoria['id'] ? 'btn-pill-active' : 'btn-pill-ghost' }}"
            >
                {{ $categoria['name'] }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach ($productos as $producto)
            <div class="card-product group">
                <div class="relative aspect-square bg-fondo overflow-hidden">
                    <img
                        src="{{ $producto['images'][0] ?? 'https://placehold.co/400x400' }}"
                        alt="{{ $producto['title'] }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
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

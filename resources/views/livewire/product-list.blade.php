<div>
    {{-- Filtro de categorias con paleta primary/accent --}}
    <div class="mb-8 flex flex-wrap gap-2">
        <button
            wire:click="filtrarPorCategoria(0)"
            class="px-5 py-2 rounded-full text-sm font-medium transition
                {{ $categoriaSeleccionada === 0 ? 'bg-primary text-white shadow-md' : 'bg-white text-dark/70 border border-accent/50 hover:bg-accent/30' }}"
        >
            Todas
        </button>

        @foreach ($categorias as $categoria)
            <button
                wire:click="filtrarPorCategoria({{ $categoria['id'] }})"
                class="px-5 py-2 rounded-full text-sm font-medium transition
                    {{ $categoriaSeleccionada === $categoria['id'] ? 'bg-primary text-white shadow-md' : 'bg-white text-dark/70 border border-accent/50 hover:bg-accent/30' }}"
            >
                {{ $categoria['name'] }}
            </button>
        @endforeach
    </div>

    {{-- Grid de productos responsivo --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($productos as $producto)
            <div class="bg-white rounded-2xl shadow-sm border border-accent/20 overflow-hidden hover:shadow-lg hover:border-accent transition-all duration-300 flex flex-col">
                {{-- Imagen del producto --}}
                <img
                    src="{{ $producto['images'][0] ?? 'https://placehold.co/300x300' }}"
                    alt="{{ $producto['title'] }}"
                    class="w-full h-48 object-cover"
                >
                {{-- Informacion del producto --}}
                <div class="p-4 flex flex-col flex-1">
                    <span class="text-xs font-semibold text-primary uppercase tracking-wider">
                        {{ $producto['category']['name'] ?? 'Sin categoria' }}
                    </span>
                    <h3 class="text-lg font-semibold mt-1 text-dark line-clamp-2">{{ $producto['title'] }}</h3>
                    <p class="text-xl font-bold text-primary mt-2">${{ number_format($producto['price'], 2) }}</p>
                    {{-- Acciones: ver detalle y favorito --}}
                    <div class="mt-auto pt-4 flex items-center justify-between">
                        <a href="{{ route('productos.detalle', $producto['id']) }}"
                           class="text-sm font-medium text-primary hover:text-primary/70 transition">
                            Ver detalle &rarr;
                        </a>
                        @auth
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
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

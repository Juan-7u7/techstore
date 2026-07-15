<div>
    {{-- Filtro de categorías --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <button
            wire:click="filtrarPorCategoria(0)"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $categoriaSeleccionada === 0 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
        >
            Todas
        </button>

        @foreach ($categorias as $categoria)
            <button
                wire:click="filtrarPorCategoria({{ $categoria['id'] }})"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $categoriaSeleccionada === $categoria['id'] ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
            >
                {{ $categoria['name'] }}
            </button>
        @endforeach
    </div>

    {{-- Grid de productos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
        @foreach ($productos as $producto)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img
                    src="{{ $producto['images'][0] ?? 'https://placehold.co/300x300' }}"
                    alt="{{ $producto['title'] }}"
                    class="w-full h-48 object-cover"
                >
                <div class="p-4">
                    <span class="text-xs font-semibold text-indigo-600 uppercase">
                        {{ $producto['category']['name'] ?? 'Sin categoría' }}
                    </span>
                    <h3 class="text-lg font-semibold mt-1">{{ $producto['title'] }}</h3>
                    <p class="text-xl font-bold text-indigo-600 mt-2">${{ number_format($producto['price'], 2) }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <a href="{{ route('productos.detalle', $producto['id']) }}"
                           class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
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
        @endforeach
    </div>
</div>

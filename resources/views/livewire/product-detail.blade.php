<div class="max-w-5xl mx-auto">
    @if ($producto)
        {{-- Tarjeta de detalle del producto --}}
        <div class="bg-white rounded-2xl shadow-sm border border-accent/20 overflow-hidden">
            <div class="md:flex">
                {{-- Galeria de imagenes --}}
                <div class="md:w-1/2 p-6">
                    <img
                        src="{{ $producto['images'][0] ?? 'https://placehold.co/400x400' }}"
                        alt="{{ $producto['title'] }}"
                        class="w-full h-80 object-cover rounded-xl"
                    >
                </div>

                {{-- Informacion del producto --}}
                <div class="p-6 md:w-1/2 flex flex-col justify-between">
                    <div>
                        <span class="text-sm font-semibold text-primary uppercase tracking-wider">
                            {{ $producto['category']['name'] ?? 'Sin categoria' }}
                        </span>
                        <h1 class="text-2xl font-bold mt-2 text-dark">{{ $producto['title'] }}</h1>
                        <p class="text-3xl font-bold text-primary mt-4">${{ number_format($producto['price'], 2) }}</p>
                        <p class="text-dark/70 mt-4 leading-relaxed">{{ $producto['description'] }}</p>
                    </div>
                    {{-- Acciones --}}
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('productos.index') }}"
                           class="text-sm font-medium text-primary hover:text-primary/70 transition inline-flex items-center gap-1">
                            &larr; Volver a productos
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
                                :key="'fav-detail-' . $producto['id']"
                            />
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-dark/50 mt-12">Producto no encontrado.</p>
    @endif
</div>

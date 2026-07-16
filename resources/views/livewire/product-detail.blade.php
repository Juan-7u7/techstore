<div class="max-w-6xl mx-auto">
    @if ($producto)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <div class="bg-fondo rounded-2xl overflow-hidden aspect-square">
                <img
                    src="{{ $producto['images'][0] ?? 'https://placehold.co/600x600' }}"
                    alt="{{ $producto['title'] }}"
                    class="w-full h-full object-cover"
                >
            </div>

            <div class="flex flex-col justify-center">
                <span class="text-xs text-muted uppercase tracking-widest font-medium">
                    {{ $producto['category']['name'] ?? 'General' }}
                </span>
                <h1 class="text-display mt-2 text-primary">{{ $producto['title'] }}</h1>
                <p class="text-3xl font-semibold text-primary mt-4">${{ number_format($producto['price'], 2) }}</p>
                <hr class="my-6 border-border/50">
                <p class="text-muted leading-relaxed text-base">{{ $producto['description'] }}</p>

                <div class="flex flex-wrap items-center gap-3 mt-8">
                    <a href="{{ route('productos.index') }}"
                       class="btn-pill-ghost text-sm gap-1.5">
                        &larr; Volver
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
    @else
        <p class="text-center text-muted mt-16">Producto no encontrado.</p>
    @endif
</div>

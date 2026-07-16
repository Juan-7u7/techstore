<div class="max-w-6xl mx-auto">
    @if ($producto)
        <nav class="flex items-center gap-2 text-sm text-muted mb-6 overflow-hidden">
            <a href="{{ route('productos.index') }}" wire:navigate class="hover:text-primary transition-colors shrink-0">Productos</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-muted/60 truncate">{{ $producto['category']['name'] ?? 'General' }}</span>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-primary truncate font-medium">{{ $producto['title'] }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-12">
            <div class="bg-fondo rounded-2xl overflow-hidden aspect-square shadow-soft-sm">
                <img
                    src="{{ $producto['images'][0] ?? asset('images/placeholder.svg') }}"
                    alt="{{ $producto['title'] }}"
                    class="w-full h-full object-cover"
                >
            </div>

            <div class="flex flex-col justify-center">
                <span class="text-xs text-muted uppercase tracking-widest font-medium">
                    {{ $producto['category']['name'] ?? 'General' }}
                </span>
                <h1 class="text-2xl sm:text-display mt-2 text-primary">{{ $producto['title'] }}</h1>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 mt-5">
                    <p class="text-3xl font-semibold text-primary">${{ number_format($producto['price'], 2) }}</p>
                    <livewire:favorito-button
                        :productoId="$producto['id']"
                        :productoData="[
                            'title' => $producto['title'],
                            'price' => $producto['price'],
                            'image' => $producto['images'][0] ?? '',
                            'category' => $producto['category']['name'] ?? '',
                        ]"
                        modo="button"
                        :key="'fav-detail-' . $producto['id']"
                    />
                    <button
                        x-data="{ copiado: false }"
                        @click="navigator.clipboard.writeText(window.location.href); copiado = true; setTimeout(() => copiado = false, 2000)"
                        class="btn-pill-ghost text-sm gap-1.5"
                        title="Copiar enlace del producto"
                    >
                        <template x-if="!copiado">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </template>
                        <template x-if="copiado">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </template>
                        <span x-text="copiado ? 'Enlace copiado' : 'Compartir'"></span>
                    </button>
                </div>

                <hr class="my-6 border-border/50">

                <p class="text-sm sm:text-base text-muted leading-relaxed">{{ $producto['description'] }}</p>

                <a href="{{ route('productos.index') }}" wire:navigate
                   class="mt-8 text-sm text-muted hover:text-primary transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Volver a productos
                </a>
            </div>
        </div>

        @if (count($relacionados) > 0)
            <section class="mt-16">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-heading text-primary">Productos relacionados</h2>
                    <span class="text-xs text-muted/60">({{ count($relacionados) }})</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($relacionados as $item)
                        <div class="card-product group">
                            <a href="{{ route('productos.detalle', $item['id']) }}" wire:navigate>
                                <div class="relative aspect-square bg-fondo overflow-hidden">
                                    <img
                                        src="{{ $item['images'][0] ?? asset('images/placeholder.svg') }}"
                                        alt="{{ $item['title'] }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    >
                                </div>
                            </a>
                            <div class="p-4 flex flex-col flex-1 gap-1.5">
                                <span class="text-xs text-muted uppercase tracking-wider font-medium">{{ $item['category']['name'] ?? 'General' }}</span>
                                <a href="{{ route('productos.detalle', $item['id']) }}" wire:navigate>
                                    <h3 class="font-heading font-semibold text-primary leading-snug line-clamp-2 group-hover:text-accent transition-colors text-sm sm:text-base">{{ $item['title'] }}</h3>
                                </a>
                                <p class="text-base sm:text-lg font-semibold text-primary mt-auto pt-2">${{ number_format($item['price'], 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @else
        <p class="text-center text-muted mt-16">Producto no encontrado.</p>
    @endif
</div>

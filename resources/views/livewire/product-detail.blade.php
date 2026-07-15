<div class="max-w-4xl mx-auto">
    @if ($producto)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                {{-- Galería de imágenes --}}
                <div class="md:w-1/2 p-4">
                    <img
                        src="{{ $producto['images'][0] ?? 'https://placehold.co/400x400' }}"
                        alt="{{ $producto['title'] }}"
                        class="w-full h-80 object-cover rounded-lg"
                    >
                </div>

                {{-- Información del producto --}}
                <div class="p-6 md:w-1/2">
                    <span class="text-sm font-semibold text-indigo-600 uppercase">
                        {{ $producto['category']['name'] ?? 'Sin categoría' }}
                    </span>
                    <h1 class="text-2xl font-bold mt-2">{{ $producto['title'] }}</h1>
                    <p class="text-3xl font-bold text-indigo-600 mt-4">${{ number_format($producto['price'], 2) }}</p>
                    <p class="text-gray-600 dark:text-gray-300 mt-4">{{ $producto['description'] }}</p>
                    <a href="{{ route('productos.index') }}"
                       class="mt-6 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                        &larr; Volver a productos
                    </a>
                </div>
            </div>
        @else
            <p class="text-center text-gray-500">Producto no encontrado.</p>
        @endif
    </div>
</div>

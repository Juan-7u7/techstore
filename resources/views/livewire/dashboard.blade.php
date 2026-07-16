<div>
    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <p class="text-sm font-medium text-dark/60 uppercase tracking-wider">Total usuarios</p>
            <p class="text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['total_usuarios'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <p class="text-sm font-medium text-dark/60 uppercase tracking-wider">Usuarios activos</p>
            <p class="text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['usuarios_activos'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <p class="text-sm font-medium text-dark/60 uppercase tracking-wider">Total favoritos</p>
            <p class="text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['total_favoritos'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <p class="text-sm font-medium text-dark/60 uppercase tracking-wider">Precio promedio</p>
            <p class="text-3xl font-heading font-bold text-primary mt-1">${{ number_format($kpis['precio_promedio'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Top 5 productos mas favoritados --}}
        <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <h3 class="text-lg font-heading font-semibold text-dark mb-4">Top 5 productos</h3>
            @if (count($productosTop) > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($productosTop as $item)
                        <li class="py-3 flex items-center gap-3">
                            @if ($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                     class="w-12 h-12 object-cover rounded-lg shrink-0">
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-dark truncate">{{ $item['title'] }}</p>
                                <p class="text-xs text-dark/60">${{ number_format($item['price'], 2) }}</p>
                            </div>
                            <span class="text-sm font-bold text-primary shrink-0">{{ $item['total'] }}x</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-dark/50">Aún no hay favoritos registrados.</p>
            @endif
        </div>

        {{-- Grafica de categorias --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
            <h3 class="text-lg font-heading font-semibold text-dark mb-4">Favoritos por categoría</h3>
            @if (count($chartData['labels']) > 0)
                <div id="react-chart"
                     data-labels="{{ json_encode($chartData['labels']) }}"
                     data-values="{{ json_encode($chartData['values']) }}">
                </div>
            @else
                <p class="text-sm text-dark/50">Aún no hay datos para mostrar.</p>
            @endif
        </div>
    </div>

    {{-- Favoritos recientes (React) --}}
    <div class="mt-6 bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
        <h3 class="text-lg font-heading font-semibold text-dark mb-4">Favoritos recientes</h3>
        <div id="react-favoritos"
             data-favoritos="{{ json_encode($favoritosRecientes) }}"></div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
@endpush

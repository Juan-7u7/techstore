<div class="space-y-8">
    <div>
        <h1 class="text-heading text-primary">Bienvenido, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-muted mt-1">Resumen de actividad de TechStore Explorer</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 -mr-4 -mt-4 rounded-full bg-accent/10"></div>
            <svg class="w-5 h-5 text-accent mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <p class="text-xs text-muted uppercase tracking-wider font-medium">Usuarios</p>
            <p class="text-2xl sm:text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['total_usuarios'] }}</p>
        </div>
        <div class="kpi-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 -mr-4 -mt-4 rounded-full bg-green-100"></div>
            <svg class="w-5 h-5 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
            </svg>
            <p class="text-xs text-muted uppercase tracking-wider font-medium">Activos</p>
            <p class="text-2xl sm:text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['usuarios_activos'] }}</p>
        </div>
        <div class="kpi-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 -mr-4 -mt-4 rounded-full bg-red-50"></div>
            <svg class="w-5 h-5 text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
            <p class="text-xs text-muted uppercase tracking-wider font-medium">Favoritos</p>
            <p class="text-2xl sm:text-3xl font-heading font-bold text-primary mt-1">{{ $kpis['total_favoritos'] }}</p>
        </div>
        <div class="kpi-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 -mr-4 -mt-4 rounded-full bg-amber-50"></div>
            <svg class="w-5 h-5 text-amber-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-muted uppercase tracking-wider font-medium">Precio prom.</p>
            <p class="text-2xl sm:text-3xl font-heading font-bold text-primary mt-1">${{ number_format($kpis['precio_promedio'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="kpi-card">
            <h3 class="font-heading font-semibold text-primary mb-4">Top 5 productos</h3>
            @if (count($productosTop) > 0)
                <ul class="divide-y divide-border/60 -mx-1">
                    @foreach ($productosTop as $i => $item)
                        <li class="py-2.5 flex items-center gap-3">
                            <span class="shrink-0 w-6 text-center text-sm font-bold {{ $i === 0 ? 'text-amber-400' : ($i === 1 ? 'text-gray-400' : ($i === 2 ? 'text-amber-700' : 'text-muted/40')) }}">
                                @if ($i === 0) 🥇 @elseif($i === 1) 🥈 @elseif($i === 2) 🥉 @else {{ $i + 1 }}. @endif
                            </span>
                            @if ($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                     class="w-10 h-10 object-cover rounded-lg shrink-0 bg-fondo">
                            @endif
                            <a href="{{ route('productos.detalle', $item['product_id']) }}" wire:navigate class="min-w-0 flex-1 group">
                                <p class="text-sm font-medium text-primary truncate group-hover:text-accent transition-colors">{{ $item['title'] }}</p>
                                <p class="text-xs text-muted">${{ number_format($item['price'], 2) }}</p>
                            </a>
                            <span class="text-sm font-semibold text-primary shrink-0">{{ $item['total'] }}x</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-6">
                    <svg class="w-10 h-10 text-muted/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-sm text-muted">Aún no hay favoritos registrados.</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2 kpi-card">
            <h3 class="font-heading font-semibold text-primary mb-4">Favoritos por categoría</h3>
            @if (count($chartData['labels']) > 0)
                <div id="react-chart"
                     data-labels="{{ json_encode($chartData['labels']) }}"
                     data-values="{{ json_encode($chartData['values']) }}">
                </div>
            @else
                <div class="text-center py-6">
                    <svg class="w-10 h-10 text-muted/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <p class="text-sm text-muted">Aún no hay datos para mostrar.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="kpi-card">
        <h3 class="font-heading font-semibold text-primary mb-4">Favoritos recientes</h3>
        <div id="react-favoritos"
             data-favoritos="{{ json_encode($favoritosRecientes) }}"></div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
@endpush

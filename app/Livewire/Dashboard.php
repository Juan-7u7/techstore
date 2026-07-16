<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

// Componente Livewire del dashboard con KPIs y graficas
class Dashboard extends Component
{
    public array $kpis = [];           // Indicadores clave: total usuarios, activos, favoritos, precio promedio
    public array $productosTop = [];   // Top 5 productos mas favoritados
    public array $chartData = [];      // Datos para la grafica de categorias (labels + values)
    public array $favoritosRecientes = []; // Favoritos del usuario actual (ultimos 5)

    // Al montar el componente calcula todos los KPIs
    public function mount(): void
    {
        $this->calcularKPIs();
        $this->obtenerFavoritosRecientes();
    }

    // Obtiene los ultimos 5 favoritos del usuario autenticado
    public function obtenerFavoritosRecientes(): void
    {
        $user = auth()->user();
        if (!$user) {
            $this->favoritosRecientes = [];
            return;
        }

        $this->favoritosRecientes = $user->favorites()
            ->latest()
            ->take(5)
            ->get()
            ->toArray();
    }

    // Calcula todos los indicadores del dashboard desde la base de datos
    public function calcularKPIs(): void
    {
        $this->kpis = [
            'total_usuarios' => User::count(),
            'usuarios_activos' => User::has('favorites')->count(),
            'total_favoritos' => Favorite::count(),
        ];

        // Precio promedio usando el JSON product_data de la BD MySQL
        $promedio = Favorite::whereNotNull('product_data->price')
            ->select(DB::raw('AVG(JSON_EXTRACT(product_data, "$.price")) as promedio'))
            ->value('promedio');
        $this->kpis['precio_promedio'] = $promedio ? round((float) $promedio, 2) : 0;

        // Productos mas agregados a favoritos (top 5) con una sola query
        $topProductos = Favorite::select(
                'favorites.product_id',
                DB::raw('count(*) as total'),
                DB::raw('(SELECT product_data FROM favorites f2 WHERE f2.product_id = favorites.product_id AND f2.product_data IS NOT NULL LIMIT 1) as product_data')
            )
            ->groupBy('favorites.product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->productosTop = $topProductos->map(function ($item) {
            $data = is_string($item->product_data) ? json_decode($item->product_data, true) : ($item->product_data ?? []);
            return [
                'product_id' => $item->product_id,
                'total' => $item->total,
                'title' => $data['title'] ?? "Producto #{$item->product_id}",
                'price' => $data['price'] ?? 0,
                'image' => $data['image'] ?? null,
            ];
        })->toArray();

        // Distribucion de favoritos por categoria para la grafica
        $categorias = Favorite::whereNotNull('product_data->category')
            ->select(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(product_data, '$.category.name')) as categoria"), DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->get();

        $this->chartData = [
            'labels' => $categorias->pluck('categoria')->toArray(),
            'values' => $categorias->pluck('total')->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}

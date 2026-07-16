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

    // Al montar el componente calcula todos los KPIs
    public function mount(): void
    {
        $this->calcularKPIs();
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

        // Productos mas agregados a favoritos (top 5)
        $topProductos = Favorite::select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->productosTop = $topProductos->map(function ($item) {
            // Busca cualquier favorito con datos del producto para obtener titulo/imagen
            $fav = Favorite::where('product_id', $item->product_id)
                ->whereNotNull('product_data')
                ->first();
            $data = $fav?->product_data;
            return [
                'product_id' => $item->product_id,
                'total' => $item->total,
                'title' => $data['title'] ?? "Producto #{$item->product_id}",
                'price' => $data['price'] ?? 0,
                'image' => $data['images'][0] ?? $data['image'] ?? null,
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

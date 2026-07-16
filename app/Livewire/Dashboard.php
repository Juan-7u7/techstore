<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public array $kpis = [];
    public array $productosTop = [];
    public array $chartData = [];

    public function mount(): void
    {
        $this->calcularKPIs();
    }

    public function calcularKPIs(): void
    {
        $this->kpis = [
            'total_usuarios' => User::count(),
            'usuarios_activos' => User::has('favorites')->count(),
            'total_favoritos' => Favorite::count(),
        ];

        $promedio = Favorite::whereNotNull('product_data->price')
            ->select(DB::raw('AVG(JSON_EXTRACT(product_data, "$.price")) as promedio'))
            ->value('promedio');
        $this->kpis['precio_promedio'] = $promedio ? round((float) $promedio, 2) : 0;

        $topProductos = Favorite::select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->productosTop = $topProductos->map(function ($item) {
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

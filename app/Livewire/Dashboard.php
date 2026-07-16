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
    public array $favoritosRecientes = [];

    public function mount(): void
    {
        $this->calcularKPIs();
        $this->obtenerFavoritosRecientes();
    }

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

        $categorias = Favorite::whereNotNull('product_data->category')
            ->select(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(product_data, '$.category')) as categoria"), DB::raw('count(*) as total'))
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

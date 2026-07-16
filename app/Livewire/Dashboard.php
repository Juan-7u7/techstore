<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
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
        $this->kpis = Cache::remember('dashboard_kpis', 300, function () {
            $promedio = Favorite::whereNotNull('product_data->price')
                ->selectRaw('AVG(CAST(JSON_EXTRACT(product_data, "$.price") AS DECIMAL(10,2))) as promedio')
                ->value('promedio');

            return [
                'total_usuarios' => User::count(),
                'usuarios_activos' => User::has('favorites')->count(),
                'total_favoritos' => Favorite::count(),
                'precio_promedio' => $promedio ? round((float) $promedio, 2) : 0,
            ];
        });

        $topIds = Favorite::selectRaw('product_id, count(*) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->productosTop = $topIds->map(function ($item) {
            $fav = Favorite::where('product_id', $item->product_id)
                ->whereNotNull('product_data')
                ->first();
            $data = $fav ? (is_string($fav->product_data) ? json_decode($fav->product_data, true) : $fav->product_data) : [];
            return [
                'product_id' => $item->product_id,
                'total' => $item->total,
                'title' => $data['title'] ?? "Producto #{$item->product_id}",
                'price' => $data['price'] ?? 0,
                'image' => $data['image'] ?? null,
            ];
        })->toArray();

        $categorias = Favorite::whereNotNull('category_name')
            ->selectRaw('category_name, count(*) as total')
            ->groupBy('category_name')
            ->orderByDesc('total')
            ->get();

        $this->chartData = [
            'labels' => $categorias->pluck('category_name')->toArray(),
            'values' => $categorias->pluck('total')->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}

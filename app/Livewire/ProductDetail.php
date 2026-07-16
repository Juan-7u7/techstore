<?php

namespace App\Livewire;

use App\Services\FakeStoreService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class ProductDetail extends Component
{
    public int $productoId;
    public ?array $producto = null;
    public array $relacionados = [];

    protected FakeStoreService $api;

    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    public function mount(int $id): void
    {
        $this->productoId = $id;
        $this->producto = $this->api->getProduct($id);

        if ($this->producto) {
            $catId = $this->producto['category']['id'] ?? 0;
            $todos = $this->api->getProductsByCategory($catId, 0, 8);
            $this->relacionados = array_values(array_filter($todos, fn($p) => $p['id'] !== $id));
        }
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}

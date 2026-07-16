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

    protected FakeStoreService $api;

    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    public function mount(int $id): void
    {
        $this->productoId = $id;
        $this->producto = $this->api->getProduct($id);
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}

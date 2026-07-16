<?php

namespace App\Livewire;

use App\Services\FakeStoreService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class ProductDetail extends Component
{
    // ID del producto recibido por la ruta
    public int $productoId;
    // Datos del producto obtenido de la API
    public ?array $producto = null;

    protected FakeStoreService $api;

    // Inyecta el servicio de la Fake Store API
    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    // Al montar el componente obtiene el producto por su ID
    public function mount(int $id): void
    {
        $this->productoId = $id;
        $this->producto = $this->api->getProduct($id);
    }

    // Renderiza la vista del detalle del producto
    public function render()
    {
        return view('livewire.product-detail');
    }
}

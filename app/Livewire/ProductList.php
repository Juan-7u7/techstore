<?php

namespace App\Livewire;

use App\Services\FakeStoreService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class ProductList extends Component
{
    public array $productos = [];
    public array $categorias = [];
    public int $categoriaSeleccionada = 0;
    public int $pagina = 0;
    public int $limite = 20;

    protected FakeStoreService $api;

    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    public function mount(): void
    {
        $this->cargarCategorias();
        $this->cargarProductos();
    }

    /**
     * Carga las categorías desde la API.
     */
    public function cargarCategorias(): void
    {
        $this->categorias = $this->api->getCategories();
    }

    /**
     * Carga productos según la categoría seleccionada.
     */
    public function cargarProductos(): void
    {
        if ($this->categoriaSeleccionada > 0) {
            $this->productos = $this->api->getProductsByCategory($this->categoriaSeleccionada);
        } else {
            $this->productos = $this->api->getProducts();
        }
    }

    /**
     * Filtra productos al seleccionar una categoría.
     */
    public function filtrarPorCategoria(int $categoriaId): void
    {
        $this->categoriaSeleccionada = $categoriaId;
        $this->cargarProductos();
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}

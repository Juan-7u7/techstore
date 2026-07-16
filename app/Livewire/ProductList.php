<?php

namespace App\Livewire;

use App\Services\FakeStoreService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class ProductList extends Component
{
    // Lista de productos y categorias obtenidos de la API
    public array $productos = [];
    public array $categorias = [];
    // ID de la categoria seleccionada (0 = todas)
    public int $categoriaSeleccionada = 0;
    public int $pagina = 0;
    public int $limite = 20;

    protected FakeStoreService $api;

    // Inyecta el servicio de la Fake Store API
    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    // Al iniciar el componente carga categorias y productos
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

    // Renderiza la vista del listado de productos
    public function render()
    {
        return view('livewire.product-list');
    }
}

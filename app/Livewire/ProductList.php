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
    public bool $hayMas = true;
    public string $busqueda = '';

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

    public function cargarCategorias(): void
    {
        $this->categorias = $this->api->getCategories();
    }

    public function cargarProductos(): void
    {
        $offset = $this->pagina * $this->limite;
        $titulo = $this->busqueda ?: null;

        if ($titulo) {
            $this->productos = $this->api->getProducts($offset, $this->limite, $titulo);
        } elseif ($this->categoriaSeleccionada > 0) {
            $this->productos = $this->api->getProductsByCategory(
                $this->categoriaSeleccionada, $offset, $this->limite
            );
        } else {
            $this->productos = $this->api->getProducts($offset, $this->limite);
        }

        $this->hayMas = count($this->productos) >= $this->limite;
    }

    public function updatedBusqueda(): void
    {
        $this->pagina = 0;
        $this->cargarProductos();
    }

    public function paginaSiguiente(): void
    {
        $this->pagina++;
        $this->cargarProductos();
    }

    public function paginaAnterior(): void
    {
        if ($this->pagina > 0) {
            $this->pagina--;
            $this->cargarProductos();
        }
    }

    public function filtrarPorCategoria(int $categoriaId): void
    {
        $this->categoriaSeleccionada = $categoriaId;
        $this->pagina = 0;
        $this->cargarProductos();
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}

<?php

namespace App\Livewire;

use App\Services\FakeStoreService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

// Componente Livewire del listado de productos con paginacion y filtro por categoria
class ProductList extends Component
{
    public array $productos = [];        // Productos cargados de la API
    public array $categorias = [];       // Categorias disponibles para filtrar
    public int $categoriaSeleccionada = 0; // ID de la categoria activa (0 = todas)
    public int $pagina = 0;             // Pagina actual para paginacion
    public int $limite = 20;            // Productos por pagina
    public bool $hayMas = true;         // Indica si hay mas paginas disponibles
    public string $busqueda = '';       // Texto de busqueda por nombre

    protected FakeStoreService $api;    // Servicio de la Fake Store API

    // Inyecta el servicio de la API externa
    public function boot(FakeStoreService $api): void
    {
        $this->api = $api;
    }

    // Al montar el componente carga categorias y productos iniciales
    public function mount(): void
    {
        $this->cargarCategorias();
        $this->cargarProductos();
    }

    // Obtiene la lista de categorias desde la API
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

    // Avanza a la siguiente pagina de resultados
    public function paginaSiguiente(): void
    {
        $this->pagina++;
        $this->cargarProductos();
    }

    // Retrocede a la pagina anterior si no esta en la primera
    public function paginaAnterior(): void
    {
        if ($this->pagina > 0) {
            $this->pagina--;
            $this->cargarProductos();
        }
    }

    // Filtra productos por categoria y reinicia la paginacion
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

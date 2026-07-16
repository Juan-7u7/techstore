<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ProductList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    private array $productosMock = [
        ['id' => 1, 'title' => 'Laptop', 'price' => 500, 'images' => ['laptop.jpg'], 'category' => ['id' => 1, 'name' => 'Electronics']],
        ['id' => 2, 'title' => 'Shirt', 'price' => 25, 'images' => ['shirt.jpg'], 'category' => ['id' => 2, 'name' => 'Clothing']],
    ];

    private array $categoriasMock = [
        ['id' => 1, 'name' => 'Electronics'],
        ['id' => 2, 'name' => 'Clothing'],
    ];

    private function fakeHttp(): void
    {
        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($this->productosMock),
        ]);
    }

    #[Test]
    public function pagina_se_renderiza(): void
    {
        $this->fakeHttp();

        $response = $this->get('/');

        $response->assertOk();
    }

    #[Test]
    public function carga_productos_al_montar(): void
    {
        $this->fakeHttp();

        $componente = Livewire::test(ProductList::class);

        $componente->assertSet('productos', $this->productosMock);
    }

    #[Test]
    public function carga_categorias_al_montar(): void
    {
        $this->fakeHttp();

        $componente = Livewire::test(ProductList::class);

        $componente->assertSet('categorias', $this->categoriasMock);
    }

    #[Test]
    public function filtrar_por_categoria_cambia_seleccion(): void
    {
        $this->fakeHttp();

        $componente = Livewire::test(ProductList::class);

        $componente->call('filtrarPorCategoria', 1);

        $componente->assertSet('categoriaSeleccionada', 1);
    }

    #[Test]
    public function filtrar_por_todas_vuelve_a_cero(): void
    {
        $this->fakeHttp();

        $componente = Livewire::test(ProductList::class);

        $componente->set('categoriaSeleccionada', 2);
        $componente->call('filtrarPorCategoria', 0);

        $componente->assertSet('categoriaSeleccionada', 0);
    }

    #[Test]
    public function pagina_inicia_en_cero(): void
    {
        $this->fakeHttp();

        $componente = Livewire::test(ProductList::class);

        $componente->assertSet('pagina', 0);
    }

    #[Test]
    public function pagina_siguiente_incrementa(): void
    {
        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($this->productosMock),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->call('paginaSiguiente');

        $componente->assertSet('pagina', 1);
    }

    #[Test]
    public function pagina_anterior_decrementa(): void
    {
        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($this->productosMock),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->set('pagina', 2);
        $componente->call('paginaAnterior');

        $componente->assertSet('pagina', 1);
    }

    #[Test]
    public function anterior_no_baja_de_cero(): void
    {
        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($this->productosMock),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->call('paginaAnterior');

        $componente->assertSet('pagina', 0);
    }

    #[Test]
    public function filtrar_categoria_resetea_pagina(): void
    {
        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($this->productosMock),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->set('pagina', 3);
        $componente->call('filtrarPorCategoria', 1);

        $componente->assertSet('pagina', 0);
    }

    #[Test]
    public function hayMas_true_cuando_hay_suficientes_productos(): void
    {
        $muchosProductos = array_map(fn($i) => [
            'id' => $i, 'title' => "Producto $i", 'price' => 10,
            'images' => ['img.jpg'], 'category' => ['id' => 1, 'name' => 'Cat'],
        ], range(1, 20));

        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($muchosProductos),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->assertSet('hayMas', true);
    }

    #[Test]
    public function hayMas_false_cuando_quedan_pocos_productos(): void
    {
        $pocosProductos = array_map(fn($i) => [
            'id' => $i, 'title' => "Producto $i", 'price' => 10,
            'images' => ['img.jpg'], 'category' => ['id' => 1, 'name' => 'Cat'],
        ], range(1, 5));

        Http::fake([
            'api.escuelajs.co/api/v1/categories' => Http::response($this->categoriasMock),
            'api.escuelajs.co/*' => Http::response($pocosProductos),
        ]);

        $componente = Livewire::test(ProductList::class);

        $componente->assertSet('hayMas', false);
    }
}

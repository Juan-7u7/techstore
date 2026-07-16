<?php

namespace Tests\Unit\Services;

use App\Services\FakeStoreService;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FakeStoreServiceTest extends TestCase
{
    private FakeStoreService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(FakeStoreService::class);
    }

    #[Test]
    public function obtiene_lista_de_productos(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response([
                ['id' => 1, 'title' => 'Producto A', 'price' => 100, 'images' => ['img.jpg'], 'category' => ['id' => 1, 'name' => 'Cat']],
                ['id' => 2, 'title' => 'Producto B', 'price' => 200, 'images' => ['img2.jpg'], 'category' => ['id' => 2, 'name' => 'Cat2']],
            ]),
        ]);

        $productos = $this->service->getProducts();

        $this->assertCount(2, $productos);
        $this->assertEquals('Producto A', $productos[0]['title']);
    }

    #[Test]
    public function getProducts_envia_offset_y_limit(): void
    {
        Http::fake();

        $this->service->getProducts(10, 5);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'offset=10')
                && str_contains($request->url(), 'limit=5');
        });
    }

    #[Test]
    public function obtiene_producto_por_id(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response([
                'id' => 42, 'title' => 'Producto Unico', 'price' => 150, 'images' => ['img.jpg'],
                'category' => ['id' => 1, 'name' => 'Cat'],
            ]),
        ]);

        $producto = $this->service->getProduct(42);

        $this->assertNotNull($producto);
        $this->assertEquals('Producto Unico', $producto['title']);
    }

    #[Test]
    public function getProduct_retorna_null_si_no_existe(): void
    {
        Http::fake(['api.escuelajs.co/*' => Http::response(null, 404)]);

        $producto = $this->service->getProduct(999);

        $this->assertNull($producto);
    }

    #[Test]
    public function obtiene_lista_de_categorias(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response([
                ['id' => 1, 'name' => 'Electronics'],
                ['id' => 2, 'name' => 'Clothing'],
            ]),
        ]);

        $categorias = $this->service->getCategories();

        $this->assertCount(2, $categorias);
        $this->assertEquals('Electronics', $categorias[0]['name']);
    }

    #[Test]
    public function obtiene_productos_por_categoria(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response([
                ['id' => 5, 'title' => 'Producto Cat', 'price' => 300, 'images' => ['img.jpg'], 'category' => ['id' => 1, 'name' => 'Cat']],
            ]),
        ]);

        $productos = $this->service->getProductsByCategory(1);

        $this->assertCount(1, $productos);
        $this->assertEquals('Producto Cat', $productos[0]['title']);
    }

    #[Test]
    public function getProductsByCategory_envia_offset_y_limit(): void
    {
        Http::fake();

        $this->service->getProductsByCategory(2, 5, 10);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/categories/2/products')
                && str_contains($request->url(), 'offset=5')
                && str_contains($request->url(), 'limit=10');
        });
    }
}

<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ProductDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    private array $productoMock = [
        'id' => 1,
        'title' => 'Producto Test',
        'price' => 99.99,
        'description' => 'Descripcion de prueba',
        'images' => ['img.jpg'],
        'category' => ['id' => 1, 'name' => 'Electronics'],
    ];

    #[Test]
    public function muestra_detalle_cuando_producto_existe(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response($this->productoMock),
        ]);

        $componente = Livewire::test(ProductDetail::class, ['id' => 1]);

        $componente->assertSet('producto', $this->productoMock);
    }

    #[Test]
    public function muestra_mensaje_si_producto_no_existe(): void
    {
        Http::fake([
            'api.escuelajs.co/*' => Http::response(null, 404),
        ]);

        $componente = Livewire::test(ProductDetail::class, ['id' => 999]);

        $componente->assertSet('producto', null);
    }
}

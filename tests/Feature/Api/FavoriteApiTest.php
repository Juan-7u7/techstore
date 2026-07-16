<?php

namespace Tests\Feature\Api;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FavoriteApiTest extends TestCase
{
    use RefreshDatabase;

    private User $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = User::factory()->create();
    }

    #[Test]
    public function lista_favoritos_retorna_vacio(): void
    {
        $response = $this->actingAs($this->usuario)->getJson('/api/favorites');

        $response->assertOk()->assertJson([]);
    }

    #[Test]
    public function lista_favoritos_requiere_autenticacion(): void
    {
        $response = $this->getJson('/api/favorites');

        $response->assertUnauthorized();
    }

    #[Test]
    public function agrega_producto_a_favoritos(): void
    {
        $response = $this->actingAs($this->usuario)->postJson('/api/favorites', [
            'product_id' => 1,
            'product_data' => ['title' => 'Producto Test', 'price' => 100],
        ]);

        $response->assertCreated()->assertJsonFragment(['product_id' => 1]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->usuario->id,
            'product_id' => 1,
        ]);
    }

    #[Test]
    public function agrega_favorito_duplicado_retorna_409(): void
    {
        Favorite::create([
            'user_id' => $this->usuario->id,
            'product_id' => 1,
            'product_data' => [],
        ]);

        $response = $this->actingAs($this->usuario)->postJson('/api/favorites', [
            'product_id' => 1,
        ]);

        $response->assertStatus(409);
    }

    #[Test]
    public function elimina_favorito_existente(): void
    {
        $favorito = Favorite::create([
            'user_id' => $this->usuario->id,
            'product_id' => 1,
            'product_data' => [],
        ]);

        $response = $this->actingAs($this->usuario)->deleteJson("/api/favorites/{$favorito->product_id}");

        $response->assertOk();

        $this->assertDatabaseMissing('favorites', ['id' => $favorito->id]);
    }

    #[Test]
    public function elimina_favorito_inexistente_retorna_404(): void
    {
        $response = $this->actingAs($this->usuario)->deleteJson('/api/favorites/999');

        $response->assertNotFound();
    }

    #[Test]
    public function elimina_favorito_requiere_autenticacion(): void
    {
        $response = $this->deleteJson('/api/favorites/1');

        $response->assertUnauthorized();
    }

    #[Test]
    public function lista_solo_favoritos_del_usuario_autenticado(): void
    {
        $otroUsuario = User::factory()->create();

        Favorite::create(['user_id' => $otroUsuario->id, 'product_id' => 99, 'product_data' => []]);
        Favorite::create(['user_id' => $this->usuario->id, 'product_id' => 1, 'product_data' => []]);

        $response = $this->actingAs($this->usuario)->getJson('/api/favorites');

        $response->assertOk()->assertJsonCount(1);
        $response->assertJsonFragment(['product_id' => 1]);
        $response->assertJsonMissing(['product_id' => 99]);
    }

    #[Test]
    public function agrega_favorito_sin_product_data(): void
    {
        $response = $this->actingAs($this->usuario)->postJson('/api/favorites', [
            'product_id' => 5,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->usuario->id,
            'product_id' => 5,
        ]);
    }

    #[Test]
    public function agrega_favorito_con_datos_invalidos(): void
    {
        $response = $this->actingAs($this->usuario)->postJson('/api/favorites', [
            'product_data' => ['algo' => 'valor'],
        ]);

        $response->assertStatus(422);
    }
}

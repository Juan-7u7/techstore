<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Modelo que almacena los productos favoritos de cada usuario
class Favorite extends Model
{
    // Atributos asignables masivamente: usuario, producto y datos del producto en JSON
    protected $fillable = ['user_id', 'product_id', 'product_data'];

    // Convierte product_data automaticamente de JSON a array de PHP
    protected function casts(): array
    {
        return [
            'product_data' => 'array',
        ];
    }

    // Relacion: un favorito pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Controlador de la API REST para gestionar favoritos del usuario autenticado
class FavoriteController extends Controller
{
    /**
     * Lista los favoritos del usuario autenticado.
     */
    public function index(Request $request): JsonResponse
    {
        // Obtiene todos los favoritos del usuario actual
        $favoritos = $request->user()->favorites()->get();

        return response()->json($favoritos);
    }

    /**
     * Agrega un producto a favoritos.
     */
    public function store(Request $request): JsonResponse
    {
        // Valida que el product_id sea requerido y product_data opcional
        $validados = $request->validate([
            'product_id' => 'required|integer',
            'product_data' => 'nullable|array',
        ]);

        // Verifica si el producto ya esta en favoritos para evitar duplicados
        $existe = $request->user()->favorites()
            ->where('product_id', $validados['product_id'])
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'El producto ya está en favoritos'], 409);
        }

        // Crea el nuevo favorito asociado al usuario
        $favorito = $request->user()->favorites()->create([
            'product_id' => $validados['product_id'],
            'product_data' => $validados['product_data'] ?? null,
        ]);

        return response()->json($favorito, 201);
    }

    /**
     * Elimina un producto de favoritos.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        // Busca el favorito por product_id del usuario actual
        $favorito = $request->user()->favorites()->where('product_id', $id)->first();

        if (!$favorito) {
            return response()->json(['message' => 'Favorito no encontrado'], 404);
        }

        $favorito->delete();

        return response()->json(['message' => 'Favorito eliminado']);
    }
}
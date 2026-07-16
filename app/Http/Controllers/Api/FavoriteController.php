<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json($request->user()->favorites()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validados = $request->validate([
            'product_id' => 'required|integer',
            'product_data' => 'nullable|array',
        ]);

        $existe = $request->user()->favorites()
            ->where('product_id', $validados['product_id'])
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'El producto ya está en favoritos'], 409);
        }

        $favorito = $request->user()->favorites()->create([
            'product_id' => $validados['product_id'],
            'product_data' => $validados['product_data'] ?? null,
        ]);

        return response()->json($favorito, 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $favorito = $request->user()->favorites()->where('product_id', $id)->first();

        if (!$favorito) {
            return response()->json(['message' => 'Favorito no encontrado'], 404);
        }

        $favorito->delete();

        return response()->json(['message' => 'Favorito eliminado']);
    }
}
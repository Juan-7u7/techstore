<?php

use App\Http\Controllers\Api\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Endpoint para obtener el usuario autenticado via token Sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas protegidas por token Sanctum para gestion de favoritos
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index']);     // Listar favoritos
    Route::post('/favorites', [FavoriteController::class, 'store']);    // Agregar favorito
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']); // Eliminar favorito
});

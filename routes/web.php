<?php

use App\Livewire\Dashboard;
use App\Livewire\ProductDetail;
use App\Livewire\ProductList;
use App\Services\FakeStoreService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function (FakeStoreService $api) {
    $productos = Cache::remember('sitemap_productos', 3600, fn() => $api->getProducts(0, 200));
    $categorias = $api->getCategories();
    return response()->view('sitemap', ['productos' => $productos, 'categorias' => $categorias])
        ->header('Content-Type', 'text/xml');
});

// Pagina principal: listado de productos con paginacion
Route::get('/', ProductList::class)->name('productos.index');
// Pagina de detalle de un producto individual
Route::get('/productos/{id}', ProductDetail::class)->name('productos.detalle');

// Dashboard con KPIs y graficas (solo para usuarios autenticados y verificados)
Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Quitar favorito desde el dashboard (React)
Route::post('/favorites/{productId}/remove', function (int $productId) {
    auth()->user()->favorites()
        ->where('product_id', $productId)
        ->firstOrFail()
        ->delete();
    return response()->json(['success' => true]);
})->middleware(['auth']);

// Pagina de perfil de usuario
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rutas de autenticacion generadas por Laravel Breeze
require __DIR__.'/auth.php';


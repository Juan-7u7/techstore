<?php

use App\Livewire\Dashboard;
use App\Livewire\ProductDetail;
use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

// Pagina principal: listado de productos con paginacion
Route::get('/', ProductList::class)->name('productos.index');
// Pagina de detalle de un producto individual
Route::get('/productos/{id}', ProductDetail::class)->name('productos.detalle');

// Dashboard con KPIs y graficas (solo para usuarios autenticados y verificados)
Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Pagina de perfil de usuario
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rutas de autenticacion generadas por Laravel Breeze
require __DIR__.'/auth.php';


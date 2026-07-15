<?php

use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

Route::get('/', ProductList::class)->name('productos.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


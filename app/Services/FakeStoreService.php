<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FakeStoreService
{
    // URL base de la Fake Store API de Platzi
    private string $baseUrl = 'https://api.escuelajs.co/api/v1';

    /**
     * Obtiene todos los productos con paginación opcional.
     */
    public function getProducts(int $offset = 0, int $limit = 20): array
    {
        // verify=false deshabilita SSL en local (entorno sin certificados CA)
        $response = Http::withOptions(['verify' => false])->get("{$this->baseUrl}/products", [
            'offset' => $offset,
            'limit' => $limit,
        ]);

        return $response->json() ?? [];
    }

    /**
     * Obtiene un producto por su ID.
     */
    public function getProduct(int $id): ?array
    {
        $response = Http::withOptions(['verify' => false])->get("{$this->baseUrl}/products/{$id}");

        return $response->json();
    }

    /**
     * Obtiene todas las categorías disponibles.
     */
    public function getCategories(): array
    {
        $response = Http::withOptions(['verify' => false])->get("{$this->baseUrl}/categories");

        return $response->json() ?? [];
    }

    /**
     * Obtiene productos filtrados por categoría.
     */
    public function getProductsByCategory(int $categoryId, int $offset = 0, int $limit = 20): array
    {
        $response = Http::withOptions(['verify' => false])->get("{$this->baseUrl}/categories/{$categoryId}/products", [
            'offset' => $offset,
            'limit' => $limit,
        ]);

        return $response->json() ?? [];
    }
}

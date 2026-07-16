<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FakeStoreService
{
    private string $baseUrl = 'https://api.escuelajs.co/api/v1';

    private function opcionesHttp(): array
    {
        return app()->environment('local', 'testing') ? ['verify' => false] : [];
    }

    public function getProducts(int $offset = 0, int $limit = 20, ?string $title = null): array
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        if ($title) $params['title'] = $title;

        $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/products", $params);

        return $response->json() ?? [];
    }

    public function getProduct(int $id): ?array
    {
        $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/products/{$id}");

        return $response->json();
    }

    public function getCategories(): array
    {
        $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/categories");

        return $response->json() ?? [];
    }

    public function getProductsByCategory(int $categoryId, int $offset = 0, int $limit = 20): array
    {
        $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/categories/{$categoryId}/products", [
            'offset' => $offset,
            'limit' => $limit,
        ]);

        return $response->json() ?? [];
    }
}

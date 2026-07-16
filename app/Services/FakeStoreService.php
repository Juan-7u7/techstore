<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
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
        $cacheKey = "fake_store_products_{$offset}_{$limit}_" . ($title ?? 'all');

        return Cache::remember($cacheKey, 300, function () use ($offset, $limit, $title) {
            $params = ['offset' => $offset, 'limit' => $limit];
            if ($title) $params['title'] = $title;

            $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/products", $params);
            return $response->json() ?? [];
        });
    }

    public function getProduct(int $id): ?array
    {
        return Cache::remember("fake_store_product_{$id}", 600, function () use ($id) {
            $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/products/{$id}");
            return $response->json();
        });
    }

    public function getCategories(): array
    {
        return Cache::remember('fake_store_categories', 3600, function () {
            $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/categories");
            return $response->json() ?? [];
        });
    }

    public function getProductsByCategory(int $categoryId, int $offset = 0, int $limit = 20): array
    {
        $cacheKey = "fake_store_category_{$categoryId}_{$offset}_{$limit}";

        return Cache::remember($cacheKey, 300, function () use ($categoryId, $offset, $limit) {
            $response = Http::withOptions($this->opcionesHttp())->get("{$this->baseUrl}/categories/{$categoryId}/products", [
                'offset' => $offset,
                'limit' => $limit,
            ]);
            return $response->json() ?? [];
        });
    }
}

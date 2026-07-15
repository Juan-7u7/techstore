<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Notifications\FavoritoAgregado;
use Livewire\Component;

class FavoritoButton extends Component
{
    public int $productoId;
    public array $productoData;
    public bool $esFavorito = false;

    public function mount(int $productoId, array $productoData = []): void
    {
        $this->productoId = $productoId;
        $this->productoData = $productoData;

        if (auth()->check()) {
            $this->esFavorito = Favorite::where('user_id', auth()->id())
                ->where('product_id', $productoId)
                ->exists();
        }
    }

    /**
     * Agrega o quita un producto de favoritos.
     */
    public function toggleFavorito(): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        $favorito = Favorite::where('user_id', auth()->id())
            ->where('product_id', $this->productoId)
            ->first();

        if ($favorito) {
            $favorito->delete();
            $this->esFavorito = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productoId,
                'product_data' => $this->productoData,
            ]);

            // Envía correo de confirmación al usuario
            $data = array_merge($this->productoData, ['product_id' => $this->productoId]);
            auth()->user()->notify(new FavoritoAgregado($data));

            $this->esFavorito = true;
        }
    }

    public function render()
    {
        return view('livewire.favorito-button');
    }
}

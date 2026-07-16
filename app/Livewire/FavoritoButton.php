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
    public string $modo = 'icon';

    public function mount(int $productoId, array $productoData = [], string $modo = 'icon'): void
    {
        $this->modo = $modo;
        $this->productoId = $productoId;
        $this->productoData = $productoData;

        if (auth()->check()) {
            $this->esFavorito = Favorite::where('user_id', auth()->id())
                ->where('product_id', $productoId)
                ->exists();
        }
    }

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

            try {
                $data = array_merge($this->productoData, ['product_id' => $this->productoId]);
                auth()->user()->notify(new FavoritoAgregado($data));
            } catch (\Throwable $e) {
                logger()->error('Error al enviar notificacion de favorito: ' . $e->getMessage());
            }

            $this->esFavorito = true;
        }
    }

    public function render()
    {
        return view('livewire.favorito-button');
    }
}

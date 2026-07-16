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

    /**
     * Agrega o quita un producto de favoritos.
     */
    public function toggleFavorito(): void
    {
        // Si no esta autenticado redirige al login
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        // Busca si ya existe el favorito en la BD
        $favorito = Favorite::where('user_id', auth()->id())
            ->where('product_id', $this->productoId)
            ->first();

        if ($favorito) {
            // Si existe lo elimina (quitar de favoritos)
            $favorito->delete();
            $this->esFavorito = false;
        } else {
            // Si no existe lo crea (agregar a favoritos)
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productoId,
                'product_data' => $this->productoData,
            ]);

            // Envia correo de confirmacion al usuario (no critico, no debe romper el flujo)
            try {
                $data = array_merge($this->productoData, ['product_id' => $this->productoId]);
                auth()->user()->notify(new FavoritoAgregado($data));
            } catch (\Throwable $e) {
                // Si el correo falla (Mailtrap caido, credenciales invalidas), el favorito ya se guardo
                logger()->error('Error al enviar notificacion de favorito: ' . $e->getMessage());
            }

            $this->esFavorito = true;
        }
    }

    // Renderiza el boton de favorito (corazon)
    public function render()
    {
        return view('livewire.favorito-button');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FavoritoAgregado extends Notification implements ShouldQueue
{
    use Queueable;

    public array $productoData;

    public function __construct(array $productoData)
    {
        $this->productoData = $productoData;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Producto agregado a favoritos')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has agregado un producto a tu lista de favoritos:')
            ->line("**{$this->productoData['title']}**")
            ->line("Precio: $" . number_format($this->productoData['price'], 2))
            ->line("Categoría: {$this->productoData['category']}")
            ->action('Ver producto', url('/productos/' . $this->productoData['product_id']))
            ->line('¡Gracias por usar TechStore Explorer!');
    }
}

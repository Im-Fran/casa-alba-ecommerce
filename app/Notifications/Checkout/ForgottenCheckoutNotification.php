<?php

namespace App\Notifications\Checkout;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;

class ForgottenCheckoutNotification extends Notification {
    public function __construct(
        protected Order $order,
        protected OrderAddress $billingAddress,
    ){
    }

    public function via($notifiable): array {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage {
        return (new MailMessage)
            ->subject('Recordatorio de Pedido Pendiente')
            ->greeting('¡Hola ' . $this->billingAddress->first_name . '!')
            ->line('Este es un recordatorio de que tienes un pedido pendiente de pago. Si quieres continuar con el pedido puedes presionar el botón de abajo.')
            ->action('Completar Pedido', URL::signedRoute('checkout.forgotten', ['order' => $this->order->id]))
            ->line('Si no deseas continuar con el pedido, puedes ignorar este mensaje, no se te cobrará nada y el pedido se cancelará automáticamente en 90 días.');
    }

    public function toArray($notifiable): array{
        return [
            'order_id' => $this->order->id,
            'billing_address' => $this->billingAddress->toArray(),
            'message' => 'Recordatorio de pedido pendiente de pago.',
            'action_url' => URL::signedRoute('checkout.forgotten', ['order' => $this->order->id]),
        ];
    }
}

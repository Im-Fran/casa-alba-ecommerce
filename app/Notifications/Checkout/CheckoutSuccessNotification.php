<?php

namespace App\Notifications\Checkout;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;

class CheckoutSuccessNotification extends Notification {

    public function __construct(
        protected Order        $order,
        protected OrderAddress $billing_address,
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage {
        return (new MailMessage)
            ->subject("¡Orden Confirmada!")
            ->markdown('emails.checkout.checkout-success', [
                'order' => $this->order,
                'billing_address' => $this->billing_address,
            ]);
    }

    public function toArray($notifiable): array {
        return [
            'order' => $this->order,
            'billing_address' => $this->billing_address,
        ];
    }
}

<?php

namespace App\Mail\Checkout;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;

class ForgottenCheckoutMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(
        protected Order        $order,
        protected OrderAddress $billing_address,
    ){}

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Recordatorio de Pedido Pendiente',
        );
    }

    public function content(): Content {
        return new Content(
            markdown: 'emails.checkout.forgotten-checkout',
            with: [
                'order' => $this->order,
                'billing_address' => $this->billing_address,
                'action_url' => URL::signedRoute('checkout.forgotten', ['order' => $this->order->id]),
            ]
        );
    }

    public function attachments(): array {
        return [];
    }
}

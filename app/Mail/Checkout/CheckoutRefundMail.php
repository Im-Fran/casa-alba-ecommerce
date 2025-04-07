<?php

namespace App\Mail\Checkout;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;
use Lunar\Models\Transaction;

class CheckoutRefundMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Order        $order,
        protected OrderAddress $billing_address,
        protected Transaction  $transaction,
    ){
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: '¡Orden Reembolsada!',
        );
    }

    public function content(): Content {
        return new Content(
            markdown: 'emails.checkout.checkout-refund',
            with: [
                'order' => $this->order,
                'billing_address' => $this->billing_address,
                'transaction' => $this->transaction,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

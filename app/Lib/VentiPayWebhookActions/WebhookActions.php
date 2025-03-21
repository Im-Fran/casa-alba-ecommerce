<?php

namespace App\Lib\VentiPayWebhookActions;

class WebhookActions {

    public static array $actions = [
        'checkout.paid' => CheckoutPaid::class,
    ];
}

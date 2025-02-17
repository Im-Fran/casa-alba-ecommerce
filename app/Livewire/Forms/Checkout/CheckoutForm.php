<?php

namespace App\Livewire\Forms\Checkout;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form {

    #[Validate(['required', 'email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'numeric', 'digits:9'])]
    public string $phone = '';

    #[Validate(['accepted'], 'Términos y Condiciones')]
    public bool $terms = false;
}

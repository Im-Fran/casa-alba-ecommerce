<?php

namespace App\Livewire\Forms\Checkout;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form {

    /* Información de Contacto */
    #[Validate(['required', 'email', 'max:255'], as: 'Correo Electrónico')]
    public string $email = '';

    #[Validate(['required', 'numeric', 'digits:9'], as: 'Teléfono')]
    public string $phone = '';

    #[Validate(['accepted'], as: 'Términos y Condiciones')]
    public bool $terms = false;

    #[Validate(as: 'Fecha de Expiración')]
    public string $expiration = '';

    /* Dirección de Envío */
    #[Validate(['required'], as: 'Dirección')]
    public string $address = '';

    #[Validate(['required'], as: 'Comuna')]
    public string $city = '13101'; // Santiago

    #[Validate(['nullable', 'digits:7'], as: 'Código Postal')]
    public string $postal = '';

    /* Dirección de Facturación */
    #[Validate(['present'], as: 'Usar Dirección de Envío')]
    public bool $sameAddress = false;

    #[Validate(['required_unless:sameAddress,1'], as: 'Dirección')]
    public string $billingAddress = '';

    #[Validate(['required_unless:sameAddress,1'], as: 'Comuna')]
    public string $billingCity = '13101'; // Santiago

    #[Validate(['nullable', 'digits:7'], as: 'Código Postal')]
    public string $billingPostal = '';
}

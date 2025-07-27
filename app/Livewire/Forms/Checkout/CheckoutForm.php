<?php

namespace App\Livewire\Forms\Checkout;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form {
    /* Información de Contacto */
    #[Validate(['required', 'string', 'max:255'], as: 'Nombre')]
    public string $name = '';

    #[Validate(['required', 'string', 'max:255'], as: 'Apellido')]
    public string $lastname = '';

    #[Validate(['required', 'email', 'max:255'], as: 'Correo Electrónico')]
    public string $email = '';

    #[Validate(['required', 'regex:/^\+\d{2}\s\d{1}\s\d{4}\s\d{4}$/'], as: 'Teléfono', message: ['phone.regex' => 'El formato del teléfono debe ser +56 9 1234 5678'])]
    public string $phone = '';

    #[Validate(['required', 'regex:/^\d{1,2}(\.\d{3}){2}-[\dkK]$/'], as: 'RUT', message: ['rut.regex' => 'El formato del RUT debe ser xx.xxx.xxx-x'])]
    public string $rut = '';

    #[Validate(['accepted'], as: 'Términos y Condiciones')]
    public bool $terms = false;

    #[Validate(as: 'Fecha de Expiración')]
    public string $expiration = '';

    /* Dirección de Envío */
    public ?int $shipping_id = null;

    #[Validate(['required'], as: 'Dirección')]
    public string $shipping_address = '';

    #[Validate(['required'], as: 'Comuna')]
    public string $shipping_city = '13101'; // Santiago

    #[Validate(['required', 'digits:7'], as: 'Código Postal')]
    public string $shipping_postal = '';

    /* Dirección de Facturación */
    #[Validate(['present'], as: 'Usar Dirección de Envío')]
    public bool $sameAddress = false;

    public ?int $billing_id = null;

    #[Validate(['required_unless:sameAddress,1'], as: 'Dirección', message: ['required_unless' => 'La dirección de facturación es obligatoria si no es la misma que la de envío'])]
    public string $billing_address = '';

    #[Validate(['required_unless:sameAddress,1'], as: 'Comuna', message: ['required_unless' => 'La comuna de facturación es obligatoria si no es la misma que la de envío'])]
    public string $billing_city = '13101'; // Santiago

    #[Validate(['required_unless:sameAddress,1', 'digits:7'], as: 'Código Postal', message: ['required_unless' => 'El código postal de facturación es obligatorio si no es el mismo que el de envío'])]
    public string $billing_postal = '';

    #[Validate(['nullable', 'max:255'], as: 'Instrucciones de Envío')]
    public ?string $deliveryInstructions = null;

    public string $shippingOption = '';
}

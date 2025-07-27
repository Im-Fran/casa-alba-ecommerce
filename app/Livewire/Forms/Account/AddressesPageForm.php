<?php

namespace App\Livewire\Forms\Account;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddressesPageForm extends Form {
    #[Validate(['required'], as: 'Dirección')]
    public string $address = '';

    #[Validate(['required'], as: 'Comuna')]
    public string $city = '13101'; // Santiago

    #[Validate(['required', 'digits:7'], as: 'Código Postal')]
    public string $postal = '';
}

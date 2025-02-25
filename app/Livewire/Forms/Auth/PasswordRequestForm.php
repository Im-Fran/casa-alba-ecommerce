<?php

namespace App\Livewire\Forms\Auth;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PasswordRequestForm extends Form {
    #[Validate(['required', 'email'], as: 'Correo Electrónico')]
    public string $email;
}

<?php

namespace App\Livewire\Forms\Auth;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form {
    #[Validate(['required', 'email'], as: 'Correo Electrónico')]
    public string $email = '';

    #[Validate(as: 'Contraseña')]
    public string $password = '';

    #[Validate(['bool'], as: 'Recordarme')]
    public bool $remember = false;

    public function rules(): array {
        return [
            'password' => ['required', Password::min(8)],
        ];
    }
}

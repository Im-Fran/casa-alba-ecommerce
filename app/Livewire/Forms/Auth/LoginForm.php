<?php

namespace App\Livewire\Forms\Auth;

use App\Rules\TurnstileRule;
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

    #[Validate(as: 'Respuesta de Captcha')]
    public string $cfTurnstileResponse = '';

    public function rules(): array {
        return [
            'password' => ['required', Password::min(8)],
//            'cfTurnstileResponse' => ['required', new TurnstileRule],
        ];
    }
}

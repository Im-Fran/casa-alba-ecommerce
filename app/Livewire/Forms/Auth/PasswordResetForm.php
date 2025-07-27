<?php

namespace App\Livewire\Forms\Auth;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PasswordResetForm extends Form {
    #[Validate(as: 'Contraseña')]
    public string $password;

    #[Validate(as: 'Confirmar contraseña')]
    public string $password_confirmation;

    public function rules(): array {
        return [
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }
}

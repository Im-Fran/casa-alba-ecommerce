<?php

namespace App\Livewire\Forms\Auth;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form {
    #[Validate(['required', 'string', 'max:255'], as: 'Nombre')]
    public string $name;

    #[Validate(['required', 'string', 'max:255'], as: 'Apellido')]
    public string $last_name;

    #[Validate(['required', 'email', 'unique:users,email'], as: 'Correo Electrónico')]
    public string $email;

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

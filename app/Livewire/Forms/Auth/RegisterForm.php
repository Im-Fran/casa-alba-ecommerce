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

    #[Validate(['required', 'regex:/^\+\d{2}\s\d{1}\s\d{4}\s\d{4}$/'], as: 'Teléfono', message: ['phone.regex' => 'El formato del teléfono debe ser +56 9 1234 5678'])]
    public string $phone = '';

    #[Validate(['required', 'regex:/^\d{1,2}(\.\d{3}){2}-[\dkK]$/'], as: 'RUT', message: ['rut.regex' => 'El formato del RUT debe ser xx.xxx.xxx-x'])]
    public string $rut = '';

    public function rules(): array {
        return [
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }
}

<?php

namespace App\Livewire\Forms\Account;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SecurityPageForm extends Form {

    #[Validate(as: 'Contraseña actual')]
    public string $current_password = '';

    #[Validate(as: 'Nueva contraseña')]
    public string $new_password = '';

    #[Validate(as: 'Confirmar nueva contraseña')]
    public string $new_password_confirmation = '';

    public function rules(): array {
        return [
            'current_password' => ['required', Password::min(8)],
            'new_password' => ['required', Password::min(8), 'confirmed'],
        ];
    }
}

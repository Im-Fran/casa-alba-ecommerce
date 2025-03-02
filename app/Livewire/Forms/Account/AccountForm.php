<?php

namespace App\Livewire\Forms\Account;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AccountForm extends Form {

    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $last_name = '';

    #[Validate(as: 'Correo Electrónico')]
    public string $email = '';

    #[Validate(['required', 'regex:/^\+\d{2}\s\d{1}\s\d{4}\s\d{4}$/'], as: 'Teléfono', message: ['phone.regex' => 'El formato del teléfono debe ser +56 9 1234 5678'])]
    public string $phone = '';

    public function rules(): array {
        return [
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(auth()->id())],
        ];
    }
}

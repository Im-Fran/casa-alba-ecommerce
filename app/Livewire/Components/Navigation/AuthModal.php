<?php

namespace App\Livewire\Components\Navigation;

use App\Models\User;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AuthModal extends Component {
    #[Modelable]
    public bool $open = false;

    #[Validate(['required', 'email'])]
    public string $email;

    public function mount(): void {
        if (session()->has('email')) {
            $this->email = session('email');
        }
    }

    public function submit(): void {
        session()->put('email', $this->email);

        if (User::whereEmail($this->email)->exists()) {
            $this->redirect(route('login'), navigate: true);
        } else {
            $this->redirect(route('register'), navigate: true);
        }
    }
}

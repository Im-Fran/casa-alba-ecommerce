<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\LoginForm;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class LoginPage extends Component {
    use WireToast;

    public LoginForm $form;

    public function mount(): void {
        if (session()->has('email')) {
            $this->form->email = session('email');
        }

        if (auth()->check()) {
            if (!auth()->user()->hasVerifiedEmail()) {
                $this->redirect(route('verification.notice'), navigate: true);

                return;
            }

            $this->redirect(route('home'), navigate: true);
        }
    }

    public function submit(): void {
        $this->form->validate();
        if (!auth()->attempt($this->form->only(['email', 'password']), remember: $this->form->remember)) {
            toast()->danger('Las credenciales no coinciden con nuestros registros.', 'Credenciales Incorrectas')->push();

            return;
        }

        session()->forget('email');
        request()->session()->regenerate();
        $this->redirect(route(auth()->user()->hasVerifiedEmail() ? 'home' : 'verification.notice'), navigate: true);
    }
}

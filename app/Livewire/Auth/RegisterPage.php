<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\RegisterForm;
use App\Models\User;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class RegisterPage extends Component {
    use WireToast;

    public RegisterForm $form;

    public function mount(): void {
        if (session()->exists('email')) {
            $this->form->email = session('email');
        }

        if (auth()->check()) {
            if (!auth()->user()->hasVerifiedEmail()) {
                $this->redirect(route('verification.resend'), navigate: true);

                return;
            }

            $this->redirect(route('home'), navigate: true);
        }
    }

    public function submit(): void {
        $user = User::create($this->form->validate());
        auth()->login($user);
        $user->sendEmailVerificationNotification();
        session()->forget('email');

        toast()->success('Por favor verifica tu correo usando el link que enviamos. Recuerda revisar el Spam!', 'Verificación Necesaria')->pushOnNextPage();
        $this->redirect(route('verification.resend'), navigate: true);
    }
}

<?php

namespace App\Livewire\Auth;

use App\Jobs\Orders\SyncGuestOrdersWithUserJob;
use App\Livewire\Forms\Auth\RegisterForm;
use App\Models\User;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class RegisterPage extends Component {
    use WireToast;

    public RegisterForm $form;

    public function mount(): void {
        if (session()->has('email')) {
            $this->form->email = session('email');
        }
    }

    public function submit(): void {
        $user = User::create($this->form->validate());
        auth()->login($user);
        $user->sendEmailVerificationNotification();
        session()->forget('email');

        SyncGuestOrdersWithUserJob::dispatch($user);

        toast()->success('Por favor verifica tu correo usando el link que enviamos. ¡Recuerda revisar el Spam!', 'Verificación Necesaria')->pushOnNextPage();
        $this->redirect(route('verification.notice'));
    }
}

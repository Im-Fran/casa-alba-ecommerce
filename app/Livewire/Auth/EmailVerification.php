<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class EmailVerification extends Component {
    use WireToast;

    public function mount(): void {
        if (auth()->check() && auth()->user()->hasVerifiedEmail()) {
            $this->redirect(route('home'));
        }
    }

    public function submit(): void {
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirect(route('home'));

            return;
        }

        auth()->user()->sendEmailVerificationNotification();

        toast()
            ->success('Se ha enviado un nuevo correo de verificación. Recuerda revisar tu carpeta de spam.', 'Correo Enviado')
            ->push();
    }
}

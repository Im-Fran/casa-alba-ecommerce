<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\PasswordRequestForm;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class PasswordRequest extends Component {
    use WireToast;

    public PasswordRequestForm $form;

    public function submit(): void {
        $status = Password::sendResetLink($this->form->validate());

        if ($status === Password::RESET_LINK_SENT) {
            toast()->info(__($status))->push();
            $this->redirect(route('auth.login'), navigate: true);

            return;
        }

        toast()->danger(__($status), 'Error')->push();
    }
}

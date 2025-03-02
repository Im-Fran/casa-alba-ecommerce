<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\PasswordRequestForm;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class PasswordRequest extends Component {
    use WireToast;

    public PasswordRequestForm $form;

    public function mount(): void {
        if(session()->has('email')) {
            $this->form->email = session('email');
        }
    }

    public function submit(): void {
        $status = Password::sendResetLink($this->form->validate());

        if ($status === Password::RESET_LINK_SENT) {
            toast()->success(__($status))->pushOnNextPage();
            $this->redirect(route('login'), navigate: true);

            return;
        }

        toast()->danger(__($status), 'Error')->push();
    }
}

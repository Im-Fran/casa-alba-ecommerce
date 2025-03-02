<?php

namespace App\Livewire\Account;

use App\Livewire\Forms\Account\AccountForm;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class AccountPage extends Component {
    use WireToast;

    public AccountForm $form;

    public function mount(): void {
        $user = auth()->user();
        collect($this->form->all())->keys()->each(fn($key) => $this->form->$key = $user->$key);
    }

    public function submit(): void {
        $user = auth()->user();
        $user->update($this->form->validate());

        $toast = toast()->success('Datos actualizados correctamente', '¡Éxito!');;

        if($user->wasChanged(['email'])) {
            $user->forceFill(['email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();
            $toast->pushOnNextPage();
            $this->redirect(route('verification.notice'));
            return;
        }

        $toast->push();
    }

}

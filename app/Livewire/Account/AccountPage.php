<?php

namespace App\Livewire\Account;

use App\Livewire\Forms\Account\AccountForm;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class AccountPage extends Component {
    use WireToast;

    public AccountForm $form;

    public function mount(): void {
        $user = auth()->user();
        $this->form->name = $user->name;
        $this->form->last_name = $user->last_name;
        $this->form->email = $user->email;
        $this->form->phone = $user->phone;
        $this->form->rut = $user->rut;
    }

    public function submit(): void {
        Auth::user()->update($this->form->validate());

        toast()->success('Datos actualizados correctamente', '¡Éxito!')->push();
    }

}

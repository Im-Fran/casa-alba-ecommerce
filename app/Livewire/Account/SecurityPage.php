<?php

namespace App\Livewire\Account;

use App\Livewire\Forms\Account\SecurityPageForm;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class SecurityPage extends Component {
    use WireToast;

    public SecurityPageForm $form;

    public function submit(): void {
        $this->form->validate();

        $user = auth()->user();

        if (!Hash::check($this->form->current_password, $user->password)) {
            $this->addError('form.current_password', 'La contraseña actual es incorrecta.');
            return;
        }

        $user->update(['password' => Hash::make($this->form->new_password)]);
        $this->form->reset();
        toast()->success('Contraseña cambiada correctamente', '¡Éxito!')->push();
    }
}

<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\PasswordResetForm;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class PasswordReset extends Component {
    use WireToast;

    private string $token;

    private string $email;

    public PasswordResetForm $form;

    public function mount(string $token): void {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function submit(): void {
        $status = Password::reset($this->form->validate(), function($user) {
            $user->forceFill([
                'password' => Hash::make($this->form->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordResetEvent($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            toast()->success(__($status))->push();
            $this->redirect(route('login'), navigate: true);

            return;
        }

        toast()->danger(__($status), 'Error')->push();
    }
}

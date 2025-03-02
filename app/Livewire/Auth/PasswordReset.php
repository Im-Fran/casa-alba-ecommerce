<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\PasswordResetForm;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class PasswordReset extends Component {
    use WireToast;

    #[Locked]
    public string $token = '';

    #[Locked]
    public string $email = '';

    public PasswordResetForm $form;

    public function mount(?string $token = null): void {
        $this->token = $token ?? request('token');
        $this->email = $email ?? request('email');
    }

    public function submit(): void {
        $data = [
            ...$this->form->validate(),
            'email' => $this->email,
            'token' => $this->token,
        ];
        $status = Password::reset($data, function($user) {
            $user->forceFill([
                'password' => Hash::make($this->form->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordResetEvent($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            toast()->success(__($status))->pushOnNextPage();
            $this->redirect(route('login'));

            return;
        }

        toast()->danger(__($status), 'Error')->push();
    }
}

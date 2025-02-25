<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class VerifyEmail extends Component {
    use WireToast;

    public string $status = '';

    public function mount(): void {
        if (!request()->hasValidSignature()) {
            $this->status = 'invalid';

            return;
        }

        $user = auth()->user();

        if (!hash_equals(request('id'), (string) $user->getKey())) {
            $this->status = 'error';

            return;
        }

        if (!hash_equals(request('hash'), sha1($user->getEmailForVerification()))) {
            $this->status = 'error';

            return;
        }

        if (auth()->user()->hasVerifiedEmail()) {
            $this->status = 'already_verified';

            return;
        }

        if (Carbon::parse(request('expires'))->isPast()) {
            $this->status = 'expired';

            return;
        }

        if (auth()->user()->markEmailAsVerified()) {
            $this->status = 'success';
        } else {
            $this->status = 'error';
        }
    }
}

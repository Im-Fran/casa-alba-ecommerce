<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyEmail extends Component {
    public string $status = '';

    public function mount(): void {
        if (auth()->user()->hasVerifiedEmail()) {
            $this->status = 'already_verified';
            return;
        }

        $this->status = auth()->user()->markEmailAsVerified() ? 'success' : 'error';
    }
}

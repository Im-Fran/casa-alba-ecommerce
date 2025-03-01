<?php

namespace App\Livewire\Components\Navigation;

use Livewire\Component;

class HeaderComponent extends Component {
    public bool $sticky = false;

    public bool $authModal = false;

    public function clickAuthModal(): void {
        if (!auth()->check()) {
            $this->authModal = !$this->authModal;

            return;
        }

        $this->redirect(route('account'), navigate: true);
    }
}

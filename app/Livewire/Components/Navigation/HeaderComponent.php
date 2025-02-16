<?php

namespace App\Livewire\Components\Navigation;

use Illuminate\View\View;
use Livewire\Component;

class HeaderComponent extends Component {
    public bool $openMobileNav = false;
    public bool $sticky = true;

    public function render(): View {
        return view('livewire.components.navigation.header-component');
    }
}

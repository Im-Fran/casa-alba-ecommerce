<?php

namespace App\Livewire\Home\Components;

use Illuminate\View\View;
use Livewire\Component;

class BannerCard extends Component {
    public function navigateToProductos(): void {
        $this->js("window.scrollTo({ top: window.screen.height/2, behavior: 'smooth' })");
    }

    public function render(): View {
        return view('livewire.home.components.banner-card');
    }
}

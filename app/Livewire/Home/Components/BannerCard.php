<?php

namespace App\Livewire\Home\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class BannerCard extends Component {

    public function render(): Application|Factory|\Illuminate\Contracts\View\View|View {
        return view('livewire.home.components.banner-card');
    }

}

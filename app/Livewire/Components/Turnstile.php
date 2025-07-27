<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Turnstile extends Component {

    #[Modelable]
    public string $response = '';
}

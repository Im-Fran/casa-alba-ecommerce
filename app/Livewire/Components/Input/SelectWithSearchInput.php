<?php

namespace App\Livewire\Components\Input;

use Illuminate\Support\Collection;
use Livewire\Component;

class SelectWithSearchInput extends Component {
    public Collection $options;
    public ?string $selected = null;

    public function mount(): void {
        $this->options = $this->options ?? collect();
    }
}

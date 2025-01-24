<?php

namespace App\Livewire\Components\Navigation;

use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchComponent extends Component {

    public bool $openSearch = false;

    #[Url(as: 'busqueda', history: true, keep: false, except: '')]
    public ?string $search = null;

    public function render(): View {
        return view('livewire.components.navigation.search-component');
    }
}

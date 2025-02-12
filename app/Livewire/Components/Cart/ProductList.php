<?php

namespace App\Livewire\Components\Cart;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Models\Cart;

class ProductList extends Component {
    #[Modelable]
    public ?Cart $cart = null;

    public function render(): View {
        return view('livewire.components.cart.product-list');
    }
}

<?php

namespace App\Livewire\Checkout\Components;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Cart;

class ProductList extends Component {

    public ?Cart $cart;

    public function mount(Cart $cart): void {
        $this->cart = $cart;
    }

    public function render(): View {
        return view('livewire.checkout.components.product-list');
    }
}

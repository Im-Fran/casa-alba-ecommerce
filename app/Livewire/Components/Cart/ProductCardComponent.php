<?php

namespace App\Livewire\Components\Cart;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\CartLine;

class ProductCardComponent extends Component {

    public CartLine $line;

    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.components.cart.product-card-component');
    }
}

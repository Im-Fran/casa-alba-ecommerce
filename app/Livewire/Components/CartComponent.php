<?php

namespace App\Livewire\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;

class CartComponent extends Component {

    public bool $open = false;

    #[Computed]
    public function cart(): ?Cart {
        return CartSession::current();
    }


    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.components.cart-component');
    }
}

<?php

namespace App\Livewire\Home\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Product;

class ProductCard extends Component {

    public bool $peek = false;
    public Product $product;

    public function addToCart(): void {
        $cart = CartSession::current();
        $cart->add($this->product->variants()->first());
    }

    #[Computed]
    public function inCart(): bool {
        return false;
    }

    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.home.components.product-card');
    }
}

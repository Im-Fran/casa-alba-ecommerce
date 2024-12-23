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

    public function addToCart(int $qty = 1): void {
        CartSession::add(purchasable: $this->product->variants()->first(), quantity: $qty);
    }

    public function removeFromCart(int $qty = 1): void {
        $line = CartSession::lines()->where('purchasable_id', $this->product->variants()->first()->id)->first();
        if($this->inCart() == 1) {
            CartSession::remove(cartLineId: $line->id);
            return;
        }
        CartSession::updateLine(cartLineId: $line->id, quantity: $line->quantity - $qty);
    }

    #[Computed]
    public function inCart(): int {
        $cart = CartSession::current();
        if($cart == null) {
            return 0;
        }

        return $cart->lines->whereIn('purchasable_id', $this->product->variants()->pluck('id'))->sum('quantity');
    }

    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.home.components.product-card');
    }
}

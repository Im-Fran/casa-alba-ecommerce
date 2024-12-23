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
        $line = CartSession::lines()->where('purchasable_id', $this->defaultVariant->id)->first();
        if($this->defaultVariant->stock < ($line?->quantity ?? 0) + $qty) {
            return;
        }
        dd('*');
        CartSession::add(purchasable: $this->defaultVariant, quantity: $qty);
    }

    public function removeFromCart(int $qty = 1): void {
        $line = CartSession::lines()->where('purchasable_id', $this->defaultVariant->id)->first();
        if($line->quantity - $qty <= 0) {
            CartSession::remove(cartLineId: $line->id);
            return;
        }

        CartSession::updateLine(cartLineId: $line->id, quantity: $line->quantity - $qty);
    }

    #[Computed]
    public function defaultVariant(): mixed {
        return $this->product->variants()->first();
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

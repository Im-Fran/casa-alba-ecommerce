<?php

namespace App\Livewire\Components\Cart;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Masmerise\Toaster\Toaster;

/**
 * @property Collection<int, CartLine> $lines
 */
class ProductList extends Component {

    #[Modelable]
    public ?Cart $cart;

    public function addToCart(CartLine $line): void {
        $qty = $line->quantity + 1;
        if($qty > $line->purchasable->stock) {
            Toaster::error('No hay suficiente stock para agregar más unidades de este producto.');
            return;
        }
        $this->cart->updateLine(cartLineId: $line->id, quantity: min($line->quantity + 1, $line->purchasable->stock));
        $this->dispatch('cart-updated');
    }

    public function remFromCart(CartLine $line): void {
        $qty = max($line->quantity - 1, 0);
        if($qty == 0) {
            $this->cart->remove(cartLineId: $line->id);
            $this->dispatch('cart-updated');
            return;
        }
        $this->cart->updateLine(cartLineId: $line->id, quantity: $qty);
        $this->dispatch('cart-updated');
    }

    public function render(): View {
        return view('livewire.components.cart.product-list');
    }
}

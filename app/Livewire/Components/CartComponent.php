<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Lunar\Pricing\DefaultPriceFormatter;
use Masmerise\Toaster\Toaster;

class CartComponent extends Component {

    public bool $openCart = false;

    public function addToCart(CartLine $line): void {
        $qty = $line->quantity + 1;
        if($qty > $line->purchasable->stock) {
            Toaster::error('No hay suficiente stock para agregar más unidades de este producto.');
            return;
        }
        $this->cart->updateLine(cartLineId: $line->id, quantity: min($line->quantity + 1, $line->purchasable->stock));
    }

    public function remFromCart(CartLine $line): void {
        $qty = max($line->quantity - 1, 0);
        if($qty == 0) {
            $this->cart->remove(cartLineId: $line->id);
            return;
        }
        $this->cart->updateLine(cartLineId: $line->id, quantity: $qty);
    }

    #[Computed]
    public function subTotal(): string {
        $cart = $this->cart;
        if($cart == null) {
            return '--';
        }


        $total = ($cart->subTotal?->value ?: 0) - ($cart->taxTotal?->value ?: 0);
        return (new DefaultPriceFormatter(value: $total, currency: $cart->currency))->unitFormatted('es-cl');
    }

    #[Computed]
    public function cart(): ?Cart {
        return CartSession::current();
    }


    public function render(): View {
        return view('livewire.components.cart-component');
    }
}

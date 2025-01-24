<?php

namespace App\Livewire\Components\Navigation;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Lunar\Pricing\DefaultPriceFormatter;
use Masmerise\Toaster\Toaster;

class CartComponent extends Component {

    public ?Cart $cart;
    public bool $openCart = false;

    public function boot(): void {
        $this->cart = CartSession::current();
    }

    public function addToCart(CartLine $line): void {
        $qty = $line->quantity + 1;
        if ($qty > $line->purchasable->stock) {
            Toaster::error('No hay suficiente stock para agregar más unidades de este producto.');
            return;
        }
        CartSession::updateLine(cartLineId: $line->id, quantity: min($line->quantity + 1, $line->purchasable->stock));
        $this->dispatch('cart-updated');
    }

    public function remFromCart(CartLine $line): void {
        $qty = max($line->quantity - 1, 0);
        if ($qty == 0) {
            CartSession::remove(cartLineId: $line->id);
        } else {
            CartSession::updateLine(cartLineId: $line->id, quantity: $qty);
        }
        $this->dispatch('cart-updated');
    }

    #[Computed]
    public function subTotal(): string {
        if ($cart = $this->cart) {
            return (new DefaultPriceFormatter(value: ($cart->subTotal?->value ?? 0) - ($cart->taxTotal?->value ?? 0), currency: $cart->currency))->unitFormatted('es-cl');
        }

        return '--';
    }

}

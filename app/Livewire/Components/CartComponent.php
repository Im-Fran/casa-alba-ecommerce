<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Pricing\DefaultPriceFormatter;

class CartComponent extends Component {
    public bool $openCart = false;

    #[Computed]
    public function subTotal(): string {
        $cart = $this->cart;
        if ($cart == null) {
            return '--';
        }

        $total = ($cart->subTotal?->value ?: 0) - ($cart->taxTotal?->value ?: 0);

        return (new DefaultPriceFormatter(value: $total, currency: $cart->currency))->unitFormatted('es-cl');
    }

    #[Computed]
    public function cart(): ?Cart {
        return CartSession::current();
    }

    #[On('closeCart')]
    public function closeCart(): void {
        $this->openCart = false;
    }

    #[On('openCart')]
    public function openCart(): void {
        $this->openCart = true;
    }

    public function render(): View {
        return view('livewire.components.cart-component');
    }
}

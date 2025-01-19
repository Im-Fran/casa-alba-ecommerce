<?php

namespace App\Livewire\Components\Cart;

use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Pricing\DefaultPriceFormatter;

class PricesDetail extends Component {
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

    public function checkout() {
        // TODO
    }

    public function render(): View {
        return view('livewire.components.cart.prices-detail');
    }
}

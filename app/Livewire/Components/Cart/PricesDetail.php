<?php

namespace App\Livewire\Components\Cart;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Models\Cart;
use Lunar\Pricing\DefaultPriceFormatter;

class PricesDetail extends Component {
    #[Modelable]
    public ?Cart $cart = null;

    #[Computed]
    public function subTotal(): string {
        if ($cart = $this->cart) {
            return (new DefaultPriceFormatter(value: ($cart->subTotal?->value ?? 0) - ($cart->taxTotal?->value ?? 0), currency: $cart->currency))->unitFormatted('es-cl');
        }

        return '--';
    }

    #[Computed]
    public function hasLines(): bool {
        return $this->cart?->lines()->count() > 0;
    }
}

<?php

namespace App\Livewire\Components\Cart;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Models\Cart;
use Lunar\Pricing\DefaultPriceFormatter;

class PricesDetail extends Component {
    #[Modelable]
    public ?Cart $cart = null;

    #[Locked]
    public bool $hasLines = false;

    #[Computed]
    public function subTotal(): string {
        $this->hasLines = $this->cart?->lines()->count() > 0;
        if ($cart = $this->cart) {
            return (new DefaultPriceFormatter(value: ($cart->subTotal?->value ?? 0) - ($cart->taxTotal?->value ?? 0), currency: $cart->currency))->unitFormatted('es-cl');
        }

        return '--';
    }
}

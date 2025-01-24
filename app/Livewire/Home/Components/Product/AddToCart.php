<?php

namespace App\Livewire\Home\Components\Product;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\ProductVariant;
use Masmerise\Toaster\Toaster;

class AddToCart extends Component {

    public string $size = 'sm';

    #[Modelable]
    public ProductVariant $variant;

    public function mount(ProductVariant $variant): void {
        $this->variant = $variant;
    }

    public function increase(): void {
        $line = CartSession::lines()->where('purchasable_id', $this->variant->id)->first();
        if ($this->stock < ($line?->quantity ?? 0) + 1) {
            Toaster::error('No hay suficiente stock para agregar más unidades de este producto.');
            return;
        }
        CartSession::add(purchasable: $this->variant, quantity: 1);
        $this->dispatch('cart-updated');
    }

    public function decrease(): void {
        $line = CartSession::lines()->where('purchasable_id', $this->variant->id)->first();
        if ($line == null) {
            return;
        }

        if (($line->quantity - 1) <= 0) {
            CartSession::remove(cartLineId: $line->id);
        } else {
            CartSession::updateLine(cartLineId: $line->id, quantity: $line->quantity - 1);
        }
        $this->dispatch('cart-updated');
    }

    #[Computed]
    public function stock(): int {
        return $this->variant->stock ?? 0;
    }

    #[Computed]
    public function inCart(): int {
        return CartSession::current()?->lines?->where('purchasable_id', $this->variant->id)?->first()?->quantity ?? 0;
    }
}

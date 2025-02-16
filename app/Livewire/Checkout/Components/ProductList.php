<?php

namespace App\Livewire\Checkout\Components;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Models\Cart;
use Usernotnull\Toast\Concerns\WireToast;

class ProductList extends Component {
    use WireToast;

    #[Modelable]
    public ?Cart $cart = null;

    public function remove(int $lineId): void {
        $this->cart->remove(cartLineId: $lineId);
        toast()->success('Producto eliminado del carrito')->push();
    }

    public function edit(int $lineId, int $qty): void {
        if($qty == 0) {
            $this->remove($lineId);
            return;
        }
        $this->cart->updateLine(cartLineId: $lineId, quantity: $qty);
        toast()->success('Producto actualizado')->push();
    }
}

<?php

namespace App\Livewire\Checkout\Components;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Usernotnull\Toast\Concerns\WireToast;

class ProductList extends Component {
    use WireToast;

    #[Modelable]
    public ?Cart $cart = null;

    public function remove(CartLine $line): void {
        CartSession::remove(cartLineId: $line->id);
        toast()->success('El producto fue eliminado del carrito.', 'Eliminado')->push();

        $this->dispatch('checkout-cart-updated');
    }

    public function edit(CartLine $line, int $qty): void {
        if($qty == 0) {
            $this->remove($line);
            return;
        } else if ($qty > $line->purchasable->stock) {
            toast()->danger('No hay suficiente stock para agregar más unidades de este producto.', 'Sin Stock')->push();
            return;
        }
        CartSession::updateLine(cartLineId: $line->id, quantity: min($qty, $line->purchasable->stock));
        toast()->success('El carrito fue actualizado correctamente.', 'Actualizado')->push();

        $this->dispatch('checkout-cart-updated');
    }
}

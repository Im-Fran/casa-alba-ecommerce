<?php

namespace App\Livewire\Checkout\Components;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Lunar\Pricing\DefaultPriceFormatter;
use Usernotnull\Toast\Concerns\WireToast;

class ProductList extends Component {
    use WireToast;

    public ?Cart $cart = null;

    public function boot(): void {
        $this->cart = CartSession::current();
    }

    public function remove(CartLine $line): void {
        CartSession::remove(cartLineId: $line->id);
        $toast = toast()->success('El producto fue eliminado del carrito.', 'Eliminado');

        if (($this->cart?->lines()?->count() ?? 0) === 0) {
            $toast->pushOnNextPage();
            $this->redirect(route('home'));

            return;
        }

        $toast->push();
    }

    public function edit(CartLine $line, int $qty): void {
        if ($qty == 0) {
            $this->remove($line);

            return;
        } elseif ($qty > $line->purchasable->stock) {
            toast()->danger('No hay suficiente stock para agregar más unidades de este producto.', 'Sin Stock')->push();

            return;
        }
        CartSession::updateLine(cartLineId: $line->id, quantity: min($qty, $line->purchasable->stock));
        toast()->success('El carrito fue actualizado correctamente.', 'Actualizado')->push();
    }

    #[Computed]
    public function subTotal(): string {
        if ($cart = $this->cart) {
            return (new DefaultPriceFormatter(value: ($cart->subTotal?->value ?? 0) - ($cart->taxTotal?->value ?? 0), currency: $cart->currency))->unitFormatted('es-cl');
        }

        return '--';
    }
}

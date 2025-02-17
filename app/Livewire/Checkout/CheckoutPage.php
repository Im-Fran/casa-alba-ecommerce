<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;

class CheckoutPage extends Component {

    public ?Cart $cart;

    public function boot(): void {
        $this->cart = CartSession::current();
    }

    public function mount(): void {
        if (!$this->cart || $this->cart?->lines()->count() == 0) {
            $this->redirect(route('home'), navigate: true);
        }
    }

}

<?php

namespace App\Livewire\Checkout;

use Illuminate\View\View;
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

    public function render(): View {
        return view('livewire.checkout.checkout-page');
    }

}

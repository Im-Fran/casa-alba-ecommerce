<?php

namespace App\Livewire\Checkout;

use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;

class CheckoutPage extends Component {

    #[Computed]
    public function cart(): ?Cart {
        return CartSession::current();
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

<?php

namespace App\Livewire\Checkout;

use App\Helpers\Helpers;
use App\Livewire\Forms\Checkout\CheckoutForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;

class CheckoutPage extends Component {

    public ?Cart $cart;
    public CheckoutForm $form;

    public function boot(): void {
        $this->cart = CartSession::current();
    }

    public function mount(): void {
        if (!$this->cart || $this->cart?->lines()->count() == 0) {
            $this->redirect(route('home'), navigate: true);
        }
    }

    public function updated($field): void {
        if($this->form->sameAddress) {
            $this->form->billingAddress = $this->form->address;
            $this->form->billingCity = $this->form->city;
            $this->form->billingPostal = $this->form->postal;
        }

        if($field == 'form.sameAddress' && !$this->form->sameAddress) {
            $this->form->billingAddress = '';
            $this->form->billingCity = '';
            $this->form->billingPostal = '';
        }
    }

    #[Computed]
    public function comunas(): Collection {
        return Helpers::comunas();
    }

}

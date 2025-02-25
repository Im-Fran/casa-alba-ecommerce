<?php

namespace App\Livewire\Checkout;

use App\Helpers\Helpers;
use App\Livewire\Forms\Checkout\CheckoutForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\Country;
use Usernotnull\Toast\Concerns\WireToast;

class CheckoutPage extends Component {
    use WireToast;

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
        if ($this->form->sameAddress) {
            $this->form->billingAddress = $this->form->address;
            $this->form->billingCity = $this->form->city;
            $this->form->billingPostal = $this->form->postal;
        }

        if ($field == 'form.sameAddress' && !$this->form->sameAddress) {
            $this->form->billingAddress = '';
            $this->form->billingCity = '';
            $this->form->billingPostal = '';
        }

        if ($field === 'form.sameAddress') {
            $this->form->resetErrorBag(['billingAddress', 'billingCity', 'billingPostal']);
        }
    }

    #[Computed]
    public function comunas(): Collection {
        return Helpers::comunas();
    }

    /* Run the checkout */
    public function checkout(): void {
        // TODO: Generar link de pago desde el proveedor

        // Redirect to payment provider

        $data = $this->form->validate();
        $country = Country::whereIso3('CHL')->first()->id;
        $addressData = [
            'first_name' => $this->form->name,
            'last_name' => $this->form->lastname,
            'country_id' => $country,
            'contact_email' => $this->form->email,
            'contact_phone' => $this->form->phone,
        ];

        dd($addressData);

        // Guarda la dirección de envío y facturación.
        $this->cart->setShippingAddress([
            ...$addressData,
            'line_one' => $this->form->address,
            'city' => $this->form->city,
            'postcode' => $this->form->postal,
            'delivery_instructions' => $this->form->deliveryInstructions,
        ])->setBillingAddress([
            ...$addressData,
            'line_one' => $this->form->billingAddress,
            'city' => $this->form->billingCity,
            'postcode' => $this->form->billingPostal,
        ]);

        if (!$this->cart->canCreateOrder()) {
            toast()->danger('No se ha podido crear la orden. Intenta más tarde.', 'Error')->push();

            return;
        }

        $order = $this->cart->createOrder();
        dd($order);
    }
}

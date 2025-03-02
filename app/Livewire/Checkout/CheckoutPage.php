<?php

namespace App\Livewire\Checkout;

use App\Helpers\Helpers;
use App\Livewire\Forms\Checkout\CheckoutForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Facades\CartSession;
use Lunar\Facades\Payments;
use Lunar\Facades\ShippingManifest;
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
            $this->redirect(route('home'));
        }

        $shippingOption = $this->shippingOptions->first();
        $this->form->shippingOption = $shippingOption->identifier;

        if(auth()->check()) {
            $user = auth()->user();
            $this->form->name = $user->name;
            $this->form->lastname = $user->last_name;
            $this->form->email = $user->email;
            $this->form->phone = $user->phone;
            $this->form->rut = $user->rut;

//            if($user->addresses->count() > 0) {
//                $address = $user->addresses->first();
//                $this->form->address = $address->line_one;
//                $this->form->city = $address->city;
//                $this->form->postal = $address->postcode;
//            }

            if($this->updateAddresses()) {
                $this->cart->setShippingOption($shippingOption);
            }
        }
    }

    public function updated($field): void {
        if($field === 'form.shippingOption') {
            $options = $this->shippingOptions;
            $shippingOption = $this->shippingOptions->firstWhere('identifier', '=', $this->form->shippingOption);
            if($shippingOption == null) {
                $shippingOption = $options->first();
                $this->form->shippingOption = $shippingOption->identifier;
            }

            if($this->updateAddresses()) {
                $this->cart->setShippingOption($shippingOption);
                $this->dispatch('cart-updated');
            }
        }

        if ($this->form->sameAddress) {
            $this->form->billingAddress = $this->form->address;
            $this->form->billingCity = $this->form->city;
            $this->form->billingPostal = $this->form->postal;
        }

        if ($field === 'form.sameAddress' && !$this->form->sameAddress) {
            $this->form->billingAddress = '';
            $this->form->billingCity = '';
            $this->form->billingPostal = '';
        }

        if ($field === 'form.sameAddress') {
            $this->form->resetErrorBag(['billingAddress', 'billingCity', 'billingPostal']);
        }
    }

    #[Computed]
    public function comunas(): array {
        return Helpers::groupedComunas();
    }

    #[Computed]
    public function shippingOptions(): Collection {
        return ShippingManifest::getOptions($this->cart);
    }

    private function updateAddresses(): bool {
        if(empty($this->form->name) || empty($this->form->lastname) || empty($this->form->email) || empty($this->form->phone) || empty($this->form->address) || empty($this->form->city) || empty($this->form->postal)) {
            return false;
        }

        $addressData = [
            'first_name' => $this->form->name,
            'last_name' => $this->form->lastname,
            'country_id' => Country::whereIso3('CHL')->first()->id,
            'contact_email' => $this->form->email,
            'contact_phone' => $this->form->phone,
        ];


        $this->cart->setShippingAddress([
            ...$addressData,
            'line_one' => $this->form->address,
            'city' => Helpers::comunas()->where('id', '=', $this->form->city)->first()['name'],
            'postcode' => $this->form->postal,
            'delivery_instructions' => $this->form->deliveryInstructions,
            'meta' => ['city_id' => $this->form->city]
        ]);

        $this->cart->setBillingAddress([
            ...$addressData,
            'line_one' => $this->form->billingAddress,
            'city' => Helpers::comunas()->where('id', '=', $this->form->billingCity)->first()['name'],
            'postcode' => $this->form->billingPostal,
            'meta' => ['city_id' => $this->form->billingCity]
        ]);

        return true;
    }

    /* Run the checkout */
    public function checkout(): void {
        // TODO: Generar link de pago desde el proveedor

        // Redirect to payment provider

        $this->form->validate();
        $this->updateAddresses();

        try {
            $order = $this->cart->createOrder();
        } catch (CartException $e) {
            toast()->danger($e->getMessage(), 'Error')->push();
            return;
        }

        $driver = Payments::driver('offline');
        dd($driver);
    }
}

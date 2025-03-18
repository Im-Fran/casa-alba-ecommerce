<?php

namespace App\Livewire\Checkout;

use App\Helpers\Helpers;
use App\Lib\VentiPay;
use App\Livewire\Forms\Checkout\CheckoutForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Lunar\DataTypes\ShippingOption;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Facades\CartSession;
use Lunar\Facades\Payments;
use Lunar\Facades\ShippingManifest;
use Lunar\Models\Address;
use Lunar\Models\Cart;
use Lunar\Models\Country;
use Lunar\Models\OrderLine;
use Lunar\Models\ProductVariant;
use Usernotnull\Toast\Concerns\WireToast;

class CheckoutPage extends Component {
    use WireToast;

    public ?Cart $cart;

    public CheckoutForm $form;

    public function boot(): void {
        $this->cart = CartSession::current();
    }

    public function mount(): void {
        if(request()->has('cancel')) {
            toast()->danger('El pago fue cancelado', 'Error')->push();
        } else if (request()->has('success')) {
            toast()->success('El pago fue exitoso', 'Éxito')->push();
        }


        if (!$this->cart || $this->cart->lines()->count() == 0) {
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

            if(($selfCustomer = $user->selfCustomer()) != null && $selfCustomer->addresses()->count() > 0) {
                $this->updateAddress($selfCustomer->addresses()->firstWhere('shipping_default', '=', true) ?? $selfCustomer->addresses()->first());
                $this->updateAddress($selfCustomer->addresses()->firstWhere('billing_default', '=', true) ?? $selfCustomer->addresses()->first(), isBilling: true);
            }

            if($this->updateAddresses()) {
                $this->cart->setShippingOption($shippingOption);
            }
        }
    }

    public function updateAddress(Address $address, bool $isBilling = false): void {
        $type = $isBilling ? 'billing' : 'shipping';
        $this->form->{"{$type}_id"} = $address->id;
        $this->form->{"{$type}_address"} = $address->line_one;
        $this->form->{"{$type}_city"} = $address->meta['city_id'];
        $this->form->{"{$type}_postal"} = $address->postcode;
        if($isBilling) {
            $this->form->sameAddress = $this->form->shipping_id == $this->form->billing_id;
        }
    }

    public function updated($field): void {
        if($field === 'form.shipping_id') {
            if(!is_null($this->form->shipping_id)) {
                $address = Address::find($this->form->shipping_id);
                if($address != null) {
                    $this->updateAddress($address);
                    $this->updateAddresses();
                }
            } else {
                $fields = ['shipping_address', 'shipping_city', 'shipping_postal'];
                $this->form->reset($fields);
                $this->form->resetErrorBag($fields);
            }
        }

        if($field === 'form.billing_id') {
            if(!is_null($this->form->billing_id)) {
                $address = Address::find($this->form->billing_id);
                if($address != null) {
                    $this->updateAddress($address, isBilling: true);
                    $this->updateAddresses();
                }
            } else {
                $fields = ['billing_address', 'billing_city', 'billing_postal'];
                $this->form->reset($fields);
                $this->form->resetErrorBag($fields);
            }
        }

        if ($this->form->sameAddress) {
            $this->form->billing_address = $this->form->shipping_address;
            $this->form->billing_city = $this->form->shipping_city;
            $this->form->billing_postal = $this->form->shipping_postal;
        }

        if ($field === 'form.sameAddress' && !$this->form->sameAddress) {
            $this->form->billing_address = '';
            $this->form->billing_city = '';
            $this->form->billing_postal = '';
        }

        if ($field === 'form.sameAddress') {
            $this->form->resetErrorBag(['billing_address', 'billing_city', 'billing_postal']);
        }

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

    #[Computed]
    public function addresses(): Collection {
        return auth()->user()?->selfCustomer()?->addresses()?->get()?->map(fn($it) => ['id' => $it->id, 'name' => "{$it->line_one}, {$it->postcode}, {$it->city}, {$it->country->name}"]) ?? collect();
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
        if(empty($this->form->name) || empty($this->form->lastname) || empty($this->form->email) || empty($this->form->phone) || empty($this->form->shipping_address) || empty($this->form->shipping_city) || empty($this->form->shipping_postal)) {
            return false;
        }

        $addressData = [
            'first_name' => $this->form->name,
            'last_name' => $this->form->lastname,
            'country_id' => Country::whereIso3('CHL')->first()->id,
            'contact_email' => $this->form->email,
            'contact_phone' => $this->form->phone,
        ];


        $types = ['shipping', 'billing'];
        foreach ($types as $type) {
            $method = $type === 'shipping' ? 'setShippingAddress' : 'setBillingAddress';
            $this->cart->$method([
                ...$addressData,
                'line_one' => $this->form->{"{$type}_address"},
                'city' => Helpers::comunas()->where('id', '=', $this->form->{"{$type}_city"})->first()['name'],
                'postcode' => $this->form->{"{$type}_postal"},
                'delivery_instructions' => $type === 'shipping' ? $this->form->deliveryInstructions : null,
                'meta' => ['city_id' => $this->form->{"{$type}_city"}, 'rut' => $this->form->rut]
            ]);
        }

        return true;
    }

    /* Run the checkout */
    public function checkout(): void {
        // TODO: Generar link de pago desde el proveedor

        // Redirect to payment provider

        $this->form->validate();
        $this->updateAddresses();

        $shippingOption = ($this->shippingOptions->where('identifier', '=', $this->form->shippingOption)->first());
        $this->cart->setShippingOption($shippingOption);

        $res = Payments::driver('ventipay')->cart($this->cart)->authorize();
        dd($res);

//        redirect()->away($redirectUri); // Redirect to check out
    }
}

<?php

namespace App\Livewire\Account;

use App\Helpers\Helpers;
use App\Livewire\Forms\Account\AddressesPageForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Models\Address;
use Lunar\Models\Country;
use Usernotnull\Toast\Concerns\WireToast;

class AddressesPage extends Component {
    use WireToast;

    public AddressesPageForm $form;
    public ?int $editingAddressId = null;
    public bool $showAddressModal = false;

    #[Computed]
    public function comunas(): array {
        return Helpers::groupedComunas();
    }

    #[Computed]
    public function addresses(): Collection {
        $customer = auth()->user()->customers()->whereVatNo(auth()->user()->rut)->first();
        return $customer->addresses ?? collect();
    }

    public function addAddress(): void {
        $this->resetForm();
        $this->editingAddressId = null;
        $this->showAddressModal = true;
    }

    public function editAddress(int $addressId): void {
        $this->resetForm();
        $this->editingAddressId = $addressId;

        $address = Address::findOrFail($addressId);
        $this->form->address = $address->line_one;
        $this->form->city = $address->meta['city_id'];
        $this->form->postal = $address->postcode;

        $this->showAddressModal = true;
    }

    public function saveAddress(): void {
        $validated = $this->form->validate();
        $customer = auth()->user()->customers()->whereVatNo(auth()->user()->rut)->first();

        $addressData = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,

            'line_one' => $validated['address'],
            'city' => Helpers::comunas()->where('id', '=', $validated['city'])->first()['name'],
            'postcode' => $validated['postal'],
            'country_id' => Country::whereIso3('CHL')->first()->id, // Chile
            'meta' => ['city_id' => $validated['city']]
        ];

        if ($this->editingAddressId) {
            $address = Address::findOrFail($this->editingAddressId);
            $address->update($addressData);
            toast()->success('Dirección actualizada correctamente', '¡Éxito!')->push();
        } else {
            $customer->addresses()->create($addressData);
            toast()->success('Dirección agregada correctamente', '¡Éxito!')->push();
        }

        $this->resetForm();
        $this->showAddressModal = false;
    }

    public function deleteAddress(int $addressId): void {
        Address::findOrFail($addressId)->delete();
        toast()->success('Dirección eliminada correctamente', '¡Éxito!')->push();
    }

    public function resetForm(): void {
        $this->form->reset();
        $this->resetValidation();
    }

    public function cancelEdit(): void {
        $this->resetForm();
        $this->showAddressModal = false;
    }

    public function setAsDefaultShipping(int $addressId): void
    {
        $customer = auth()->user()->customers()->whereVatNo(auth()->user()->rut)->first();

        // Reset all shipping defaults for this customer
        $customer->addresses()->update(['shipping_default' => false]);

        // Set the selected address as default
        Address::findOrFail($addressId)->update(['shipping_default' => true]);

        toast()->success('Dirección de envío predeterminada actualizada', '¡Éxito!')->push();
    }

    public function setAsDefaultBilling(int $addressId): void
    {
        $customer = auth()->user()->customers()->whereVatNo(auth()->user()->rut)->first();

        // Reset all billing defaults for this customer
        $customer->addresses()->update(['billing_default' => false]);

        // Set the selected address as default
        Address::findOrFail($addressId)->update(['billing_default' => true]);

        toast()->success('Dirección de facturación predeterminada actualizada', '¡Éxito!')->push();
    }
}

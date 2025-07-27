<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-start justify-center">
        <div class="container mx-auto grid grid-cols-12 gap-20">
            <div class="col-span-3 w-full">
                <!-- Sidebar -->
                <livewire:account.components.sidebar/>
            </div>
            <div class="mx-auto space-y-6 col-span-9 w-full">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-xl font-semibold">Mis Direcciones</h2>
                        <x-button wire:click="addAddress" class="btn btn-primary">
                            <x-mary-icon name="o-plus" class="w-5 h-5 me-2" />
                            Agregar Dirección
                        </x-button>
                    </div>

                    @empty($this->addresses)
                        <div class="text-center py-10">
                            <div class="text-gray-400 mb-2">
                                <x-mary-icon name="o-map-pin" class="w-12 h-12 mx-auto" />
                            </div>
                            <p class="text-gray-500">No tienes direcciones registradas</p>
                            <x-button wire:click="addAddress" class="btn btn-outline btn-primary mt-4">
                                Agregar tu primera dirección
                            </x-button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($this->addresses->sortBy('created_at') as $address)
                                <div class="border rounded-lg p-4 relative">
                                    <div class="absolute right-2 top-2 flex space-x-1">
                                        <x-button wire:click="editAddress({{ $address->id }})" size="sm" class="btn-ghost">
                                            <x-mary-icon name="o-pencil" class="w-4 h-4" />
                                        </x-button>
                                        <x-button
                                            wire:click="deleteAddress({{ $address->id }})"
                                            wire:confirm="¿Estás seguro de eliminar esta dirección?"
                                            size="sm"
                                            class="btn-ghost text-error"
                                        >
                                            <x-mary-icon name="o-trash" class="w-4 h-4" />
                                        </x-button>
                                    </div>
                                    <div class="font-medium">{{ $address->line_one }}</div>
                                    <div class="text-sm text-gray-500">
                                        <b>Comuna:</b> {{ $address->city }}
                                    </div>
                                    <div class="text-sm text-gray-500"><b>C.P.</b> {{ $address->postcode }}</div>

                                    <!-- Default address flags -->
                                    <div class="mt-2 flex flex-col text-sm">
                                        @if($address->shipping_default)
                                            <div class="text-success flex items-center">
                                                <x-mary-icon name="o-check-circle" class="w-4 h-4 mr-1" />
                                                <span>Dirección de envío predeterminada</span>
                                            </div>
                                        @endif

                                        @if($address->billing_default)
                                            <div class="text-success flex items-center">
                                                <x-mary-icon name="o-check-circle" class="w-4 h-4 mr-1" />
                                                <span>Dirección de facturación predeterminada</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Set as default links -->
                                    <div class="mt-3 pt-3 border-t flex justify-between text-xs">
                                        @if(!$address->shipping_default)
                                            <x-button wire:click="setAsDefaultShipping({{ $address->id }})" size="xs" class="btn-link text-primary">
                                                Usar para envíos
                                            </x-button>
                                        @endif

                                        @if(!$address->billing_default)
                                            <x-button wire:click="setAsDefaultBilling({{ $address->id }})" size="xs" class="btn-link text-primary">
                                                Usar para facturación
                                            </x-button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>

    <!-- Modal for adding/editing addresses -->
    <x-modal wire:model="showAddressModal">
        <x-card title="{{ $editingAddressId ? 'Editar Dirección' : 'Agregar Dirección' }}">
            <x-form wire:submit.prevent="saveAddress" class="space-y-4">
                <x-input
                    icon="o-map-pin"
                    label="Dirección"
                    autocomplete="shipping street-address"
                    placeholder="Calle, número, dpto/casa"
                    wire:model.blur="form.address"
                    required
                    first-error-only
                />

                <x-select-group
                    wire:key="checkout_comunas"
                    icon="o-building-library"
                    label="Comuna"
                    autocomplete="shipping address-level2"
                    :options="$this->comunas"
                    wire:model.live.debounce="form.city"
                    required
                    first-error-only
                />

                <x-input
                    icon="o-hashtag"
                    label="Código Postal"
                    autocomplete="shipping postal-code"
                    placeholder="8320000"
                    x-mask="9999999"
                    inputmode="tel"
                    wire:model.blur="form.postal"
                    required
                    first-error-only
                />

                <div class="flex justify-end gap-x-4">
                    <x-button type="button" wire:click="cancelEdit" class="btn btn-ghost">
                        Cancelar
                    </x-button>
                    <x-button type="submit" class="btn btn-primary" spinner="saveAddress">
                        Guardar
                    </x-button>
                </div>
            </x-form>
        </x-card>
    </x-modal>
</div>

<div>
    <div class="h-full w-full min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <livewire:checkout.components.product-list wire:model="cart"/>

            <form wire:submit.prevent="checkout" class="col-span-1 p-[4.5rem]" x-data="{ contact: true, payment: true, shipping: {{ (!empty($form->shipping_address) && !empty($form->shipping_city) && !empty($form->shipping_postal)) ? 'false' : 'true' }}, billing: {{ ($form->sameAddress || (!empty($form->billing_address) && !empty($form->billing_city) && !empty($form->billing_postal)) ? 'false' : 'true') ? 'false' : 'true' }}, shipping_options: false }">
                <div class="flex flex-col gap-10 p-2">
                    <!-- Información de Contacto -->
                    <section class="flex flex-col space-y-6">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="contact = !contact">
                            <h4 class="font-semibold text-xl">Información de Contacto</h4>
                            <x-heroicon-o-plus x-bind:class="contact ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="contact" x-collapse>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <x-input
                                    label="Nombre"
                                    placeholder="Juan"
                                    autocomplete="name"
                                    wire:model.live.debounce="form.name"
                                    required
                                    first-error-only
                                />

                                <x-input
                                    label="Apellido"
                                    placeholder="Pérez"
                                    autocomplete="family-name"
                                    wire:model.live.debounce="form.lastname"
                                    required
                                    first-error-only
                                />
                            </div>

                            <x-input
                                label="Correo Electrónico"
                                placeholder="mi@correo.cl"
                                autocomplete="email"
                                type="email"
                                inputmode="email"
                                wire:model.live.debounce="form.email"
                                autofocus
                                required
                                first-error-only
                            />

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <x-input
                                    icon="o-phone"
                                    label="Número de Teléfono"
                                    placeholder="+56 9 1234 5678"
                                    autocomplete="tel"
                                    type="tel"
                                    inputmode="tel"
                                    x-mask="+99 9 9999 9999"
                                    wire:model.live.debounce="form.phone"
                                    required
                                    first-error-only
                                />

                                <x-input
                                    icon="o-identification"
                                    label="RUT"
                                    placeholder="99.999.999-9"
                                    x-mask:dynamic="$input.length < 12 ? '9.999.999-99' : '99.999.999-9'"
                                    hint="Si tu RUT termina en K, reemplázalo por un 0"
                                    inputmode="tel"
                                    wire:model.live.debounce="form.rut"
                                    required
                                    first-error-only
                                />
                            </div>

                            <div class="flex items-center justify-start">
                                <x-checkbox
                                    label="He leído los Términos y Condiciones de la tienda."
                                    wire:model.live="form.terms"
                                    first-error-only
                                />
                            </div>

                            <div class="border-b border-neutral-300"/>
                        </div>
                    </section>

                    <!-- Datos de Envío -->
                    <section class="flex flex-col space-y-6">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="shipping = !shipping">
                            <h4 class="font-semibold text-xl">Datos de Envío</h4>
                            <x-heroicon-o-plus x-bind:class="shipping ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="shipping" x-collapse>
                            @if($this->addresses?->count() > 0)
                                <x-select
                                    label="Seleccionar Dirección"
                                    placeholder="Selecciona una dirección"
                                    hint="Elige una de tus direcciones guardadas."
                                    :options="$this->addresses"
                                    wire:model.live="form.shipping_id"
                                />
                            @endif

                            <x-input
                                icon="o-map-pin"
                                label="Dirección"
                                autocomplete="shipping street-address"
                                placeholder="Calle, número, dpto/casa"
                                wire:model.blur="form.shipping_address"
                                required
                                first-error-only
                            />

                            <x-select-group
                                wire:key="checkout_comunas"
                                icon="o-building-library"
                                label="Comuna"
                                autocomplete="shipping address-level2"
                                :options="$this->comunas"
                                wire:model.live.debounce="form.shipping_city"
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
                                wire:model.blur="form.shipping_postal"
                                required
                                first-error-only
                            />

                            <x-textarea
                                label="Notas de Envío"
                                placeholder="Dejar en conserjería."
                                wire:model="form.deliveryInstructions"
                                first-error-only
                            />

                            <div class="border-b border-neutral-300"/>
                        </div>
                    </section>

                    <!-- Dirección de Facturación -->
                    <section class="flex flex-col space-y-6">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="billing = !billing">
                            <h4 class="font-semibold text-xl">Dirección de Facturación</h4>
                            <x-heroicon-o-plus x-bind:class="billing ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div x-data="{ sameAddress: $wire.entangle('form.sameAddress').live }" class="flex flex-col space-y-6" x-show="billing" x-collapse>
                            <x-checkbox
                                label="Usar la misma dirección de envío."
                                x-model="sameAddress"
                                first-error-only
                            />


                            @if($this->addresses?->count() > 0)
                                <div x-show="!sameAddress" x-collapse>
                                    <x-select
                                        label="Seleccionar Dirección"
                                        placeholder="Selecciona una dirección"
                                        hint="Elige una de tus direcciones guardadas."
                                        :options="$this->addresses"
                                        wire:model.live="form.billing_id"
                                    />
                                </div>
                            @endif

                            <div class="flex flex-col space-y-6">
                                <x-input
                                    icon="o-map-pin"
                                    class="disabled:border disabled:border-neutral-300"
                                    label="Dirección"
                                    autocomplete="billing street-address"
                                    placeholder="Calle 123"
                                    wire:model.blur="form.billing_address"
                                    x-bind:disabled="sameAddress"
                                    required
                                    first-error-only
                                />

                                <x-select-group
                                    wire:key="checkout_comunas"
                                    icon="o-building-library"
                                    class="disabled:border disabled:border-neutral-300"
                                    label="Comuna"
                                    autocomplete="billing address-level2"
                                    :options="$this->comunas"
                                    wire:model.live.debounce="form.billing_city"
                                    x-bind:disabled="sameAddress"
                                    required
                                    first-error-only
                                />

                                <x-input
                                    icon="o-hashtag"
                                    class="disabled:border disabled:border-neutral-300"
                                    label="Código Postal"
                                    autocomplete="billing postal-code"
                                    placeholder="8320000"
                                    inputmode="tel"
                                    wire:model.blur="form.billing_postal"
                                    x-bind:disabled="sameAddress"
                                    x-mask="9999999"
                                    required
                                    first-error-only
                                />
                            </div>
                            <div class="border-b border-neutral-300"/>
                        </div>
                    </section>

                    <!-- Opciones de Envío -->
                    <section class="flex flex-col space-y-6">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="shipping_options = !shipping_options">
                            <h4 class="font-semibold text-xl">Opciones de Envío</h4>
                            <x-heroicon-o-plus x-bind:class="shipping_options ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="shipping_options" x-collapse>
                            <div x-data="{ selectedShippingOption: $wire.entangle('form.shippingOption').live, loading: false }" class="grid grid-cols-2 gap-4 w-full">
                                @foreach($this->shippingOptions as $shippingOption)
                                    <div x-data="{ id: '{{ $shippingOption->identifier }}', name: '{{ $shippingOption->name }}', description: '{{ $shippingOption->description }}', price: '{{ $shippingOption->price->value === 0 ? 'Gratis' : ($shippingOption->price->unitFormatted('es-cl') ?? '--') }}' }" wire:key="shipping_{{ $shippingOption->identifier }}" class="flex flex-col items-start justify-between bg-base-100 border rounded-md p-4 col-span-1 cursor-pointer hover:shadow-xl transition duration-300" x-bind:class="selectedShippingOption === id ? 'border-primary' : 'border-neutral-400'" x-on:click="async () => { if(loading){return;} if(selectedShippingOption === id) {return;}  loading=true; await $wire.$set('form.shippingOption', id); loading=false; }">
                                        <div class="flex flex-col items-start justify-start w-full">
                                            <div class="flex items-center justify-between w-full">
                                                <h3 class="font-semibold text-sm" x-text="name"></h3>
                                                <x-heroicon-o-check-circle class="w-5 h-5 text-primary fill-primary-content" x-show="selectedShippingOption === id"/>
                                            </div>

                                            <span class="text-sm text-neutral-500 w-5/6" x-text="description"></span>
                                        </div>

                                        <span class="font-semibold text-neutral-800 pt-2.5 text-sm" x-text="price"></span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <div class="py-10"/>

                    <x-button type="submit" class="btn rounded-md btn-primary w-full" icon-right="o-shopping-cart" spinner>
                        Finalizar Compra
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>

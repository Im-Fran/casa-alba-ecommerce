<div>
    <div class="h-full w-full min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <livewire:checkout.components.product-list wire:model="cart"/>

            <div class="col-span-1 p-20" x-data="{ contact: true, payment: true, shipping: true, billing: true, summary: true }">
                <div class="flex flex-col gap-10">
                    <!-- Información de Contacto -->
                    <section class="flex flex-col space-y-6 border-b border-neutral-300 pb-10">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="contact = !contact">
                            <h4 class="font-semibold text-xl">Información de Contacto</h4>
                            <x-heroicon-o-plus x-bind:class="contact ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="contact" x-collapse>
                            <x-input
                                class="rounded-md"
                                label="Correo Electrónico"
                                placeholder="mi@correo.cl"
                                autocomplete="email"
                                type="email"
                                wire:model.live.debounce="form.email"
                                autofocus
                                first-error-only
                            />

                            <x-input
                                icon="flag.4x3-cl"
                                class="rounded-md"
                                label="Número de Teléfono"
                                placeholder="912345678"
                                autocomplete="tel"
                                type="tel"
                                wire:model.live.debounce="form.phone"
                                first-error-only
                            />

                            <div class="flex items-center justify-start">
                                <x-checkbox
                                    label="He leído los Términos y Condiciones de la tienda."
                                    wire:model.live="form.terms"
                                    first-error-only
                                />
                            </div>
                        </div>
                    </section>


                    <!-- Dirección de Envío -->
                    <section class="flex flex-col space-y-6 border-b border-neutral-300 pb-10">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="shipping = !shipping">
                            <h4 class="font-semibold text-xl">Dirección de Envío</h4>
                            <x-heroicon-o-plus x-bind:class="shipping ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="shipping" x-collapse>
                            <x-input
                                icon="o-map-pin"
                                class="rounded-md"
                                label="Dirección"
                                autocomplete="shipping street-address"
                                placeholder="Calle 123"
                                wire:model.live.debounce="form.address"
                                first-error-only
                            />

                            <x-select
                                wire:key="checkout_comunas"
                                icon="o-building-library"
                                class="rounded-md"
                                label="Comuna"
                                autocomplete="shipping address-level2"
                                :options="$this->comunas"
                                wire:model.live.live.debounce="form.city"
                                first-error-only
                            />

                            <x-input
                                icon="o-hashtag"
                                class="rounded-md"
                                label="Código Postal"
                                autocomplete="shipping postal-code"
                                placeholder="8320000"
                                wire:model.live.debounce="form.postal"
                                first-error-only
                            />
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

                            <div class="flex flex-col space-y-6">
                                <x-input
                                    icon="o-map-pin"
                                    class="rounded-md disabled:border disabled:border-neutral-300"
                                    label="Dirección"
                                    autocomplete="billing street-address"
                                    placeholder="Calle 123"
                                    wire:model.live.debounce="form.billingAddress"
                                    x-bind:disabled="sameAddress"
                                    first-error-only
                                />

                                <x-select
                                    wire:key="checkout_comunas"
                                    icon="o-building-library"
                                    class="rounded-md disabled:border disabled:border-neutral-300"
                                    label="Comuna"
                                    autocomplete="billing address-level2"
                                    :options="$this->comunas"
                                    wire:model.live.live.debounce="form.billingCity"
                                    x-bind:disabled="sameAddress"
                                    first-error-only
                                />

                                <x-input
                                    icon="o-hashtag"
                                    class="rounded-md disabled:border disabled:border-neutral-300"
                                    label="Código Postal"
                                    autocomplete="billing postal-code"
                                    placeholder="8320000"
                                    wire:model.live.debounce="form.billingPostal"
                                    x-bind:disabled="sameAddress"
                                    first-error-only
                                />
                            </div>
                        </div>
                    </section>

                    <!-- Resumen de la Compra -->
                    <section class="flex flex-col space-y-6">
                        <div class="flex items-center justify-between w-full cursor-pointer" @click="summary = !summary">
                            <h4 class="font-semibold text-xl">Resumen de la Compra</h4>
                            <x-heroicon-o-plus x-bind:class="summary ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                        </div>

                        <div class="flex flex-col space-y-6" x-show="summary" x-collapse>
                            <div class="flex justify-between text-md font-medium text-neutral-800">
                                <span>IVA</span>
                                <span>{{ $this->cart->taxTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                            </div>
                            <div class="flex justify-between text-md font-medium text-neutral-800">
                                <span>Envío</span>
                                <span>{{ $this->cart->shippingTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-semibold text-primary mt-2">
                                <span>Total</span>
                                <span>{{ $this->cart->total?->unitFormatted('es-cl') ?? '--' }}</span>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

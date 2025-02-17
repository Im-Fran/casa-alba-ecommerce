<div>
    <livewire:components.navigation.header-component :sticky="false"/>

    <div class="container mx-auto h-full w-full min-h-screen pt-[10rem]">
        <div class="grid grid-cols-10 gap-32">
            <div class="col-span-5">
                <livewire:checkout.components.product-list
                    wire:model="cart"
                />

                <!-- Pricing details -->
                <div class="flex flex-col p-4 mt-4 ">
                    <div class="flex justify-between text-md font-medium text-neutral-800">
                        <span>Sub Total</span>
                        <span>{{ $this->subTotal }}</span>
                    </div>
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
            </div>
            <div class="col-span-5" x-data="{ currentSelection: 'contact' }">
                <div class="flex flex-col">
                    <section class="flex flex-col space-y-6 border-b border-neutral-300 pb-10">
                        <h4 class="font-semibold text-xl">Información de Contacto</h4>

                        <x-input
                            class="rounded-md"
                            label="Correo Electrónico"
                            placeholder="mi@correo.cl"
                            wire:model.live="form.email"
                            first-error-only
                        />

                        <x-input
                            icon="flag.4x3-cl"
                            class="rounded-md"
                            label="Número de Teléfono"
                            placeholder="912345678"
                            wire:model.live="form.phone"
                            first-error-only
                        />

                        <div class="flex items-center justify-start">
                            <x-checkbox
                                label="He leído los Términos y Condiciones de la tienda."
                                wire:model.live="form.terms"
                                first-error-only
                            />
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

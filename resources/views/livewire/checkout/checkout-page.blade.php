<div>
    <livewire:components.navigation.header-component :sticky="false"/>

    <div class="container mx-auto h-full w-full min-h-screen pt-[10rem]">
        <div class="grid grid-cols-10 gap-10">
            <div class="col-span-4">
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
            <div class="col-span-6">

            </div>
        </div>
    </div>
</div>

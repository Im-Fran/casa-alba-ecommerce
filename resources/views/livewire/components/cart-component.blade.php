<div>
    <x-drawer title="Carrito de Compras" wire:model="openCart" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[90vh]">
            <livewire:components.cart.product-list
                wire:model="cart"
            />
            @if(count($this->cart?->lines ?: []) > 0)
                <div class="flex flex-col mt-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm">Sub Total</p>
                        <span class="text-sm">{{ $this->subTotal }}</span>
                    </div>

                    <div class="flex items-center justify-between mt-0.5">
                        <p class="text-sm">IVA</p>
                        <span class="text-sm">{{ $this->cart?->taxTotal?->unitFormatted('es-cl') ?: '--' }}</span>
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <p class="text-sm">Total</p>
                        <span class="text-sm">{{ $this->cart?->total?->unitFormatted('es-cl') ?: '--' }}</span>
                    </div>

                    <x-button wire:click="checkout" class="btn-primary text-neutral-50 mt-4" label="Ir a Pagar"/>
                </div>
            @endif
        </div>
    </x-drawer>

    <x-lucide-shopping-bag wire:click.stop="$toggle('openCart')" class="hover:text-primary w-8 h-8 cursor-pointer"/>

    @script
    <script>$wire.on('cart-updated', () => $wire.$refresh());</script>
    @endscript
</div>

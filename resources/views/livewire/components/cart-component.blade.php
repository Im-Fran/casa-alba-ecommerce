<div>
    <x-drawer title="Carrito de Compras" wire:model="open" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[90vh]">
            <div class="flex flex-col max-h-[70vh]">
                {{-- Dummy Product Card --}}
                @foreach($this->cart->lines as $line)
                    <livewire:components.cart.product-card-component :line="$line" wire:key="{{ $line->id }}"/>
                @endforeach
            </div>
            <div class="flex flex-col mt-4">
{{--                <div class="flex items-center justify-between">--}}
{{--                    <p class="text-sm">Sub Total</p>--}}
{{--                    <span class="text-sm">{{ $this->cart->subTotal->unitFormatted('es-cl') }}</span>--}}
{{--                </div>--}}

{{--                <div class="flex items-center justify-between mt-0.5">--}}
{{--                    <p class="text-sm">IVA</p>--}}
{{--                    <span class="text-sm">{{ $this->cart->taxTotal->unitFormatted('es-cl') }}</span>--}}
{{--                </div>--}}

                <div class="flex items-center justify-between mt-2">
                    <p class="text-sm">Total</p>
                    <span class="text-sm">{{ $this->cart->total->unitFormatted('es-cl') }}</span>
                </div>

                <x-button wire:click="checkout" class="btn-primary text-neutral-50 mt-4" label="Ir a Pagar"/>
            </div>
        </div>
    </x-drawer>

    <x-lucide-shopping-bag wire:click.stop="$toggle('open')" class="hover:text-primary w-6 h-6"/>
</div>

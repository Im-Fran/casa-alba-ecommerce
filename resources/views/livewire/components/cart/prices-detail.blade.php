<div class="flex flex-col mt-4" x-on:cart-updated.window="$wire.$refresh()">
    @if(count($this->cart?->lines ?: []) > 0)
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
    @endif
</div>

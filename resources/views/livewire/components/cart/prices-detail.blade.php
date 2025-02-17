<div class="flex flex-col mt-4">
    @if($this->hasLines)
        <div class="border-t border-secondary my-10"></div>


        <div class="flex items-center justify-between">
            <span class="text-sm flex-grow flex items-center">Sub Total</span>
            <span class="text-sm text-primary font-bold">{{ $this->subTotal }}</span>
        </div>

        <div class="flex items-center justify-between mt-0.5">
            <span class="text-sm flex-grow flex items-center">IVA</span>
            <span class="text-sm text-primary font-bold">{{ $this->cart?->taxTotal?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <div class="flex items-center justify-between mt-2">
            <span class="text-sm flex-grow flex items-center">Total</span>
            <span class="text-sm text-primary font-bold">{{ $this->cart?->total?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <x-button link="{{ route('checkout') }}" wire:click="$parent.$toggle('openCart')" class="btn btn-primary mt-4" label="Ir a Pagar" wire:navigate/>
        <div class="flex flex-col items-center justify-center">
            <x-button wire:click="$parent.$toggle('openCart')" class="btn btn-primary btn-link">Seguir comprando</x-button>
        </div>
    @endif
</div>

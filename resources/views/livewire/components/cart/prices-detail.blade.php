<div class="flex flex-col mt-4">
    @if($this->hasLines)
        <div class="flex items-center justify-between">
            <p class="text-sm">Sub Total</p>
            <span class="text-sm">{{ $this->subTotal }}</span>
        </div>

        <div class="flex items-center justify-between mt-0.5">
            <p class="text-sm">IVA</p>
            <span class="text-sm">{{ $this->cart?->taxTotal?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <div class="flex items-center justify-between mt-2">
            <p class="text-sm">Total</p>
            <span class="text-sm">{{ $this->cart?->total?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <x-button link="{{ route('checkout') }}" class="btn btn-primary mt-4" label="Ir a Pagar" wire:navigate/>
        <div class="flex flex-col items-center justify-center">
            <x-button wire:click="$parent.$toggle('openCart')" class="btn btn-primary btn-link">Seguir comprando</x-button>
        </div>
    @endif
</div>

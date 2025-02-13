<div class="flex flex-col mt-4">
    @if($this->hasLines)
        <div class="border-t border-secondary my-10"></div>


        <div class="flex items-center justify-between">
            <p class="text-sm flex-grow flex items-center">
                <span>Sub Total</span>
                <span class="flex-1 border-dashed border-b border-gray-400 mx-2"></span>
            </p>
            <span class="text-sm text-primary font-bold">{{ $this->subTotal }}</span>
        </div>

        <div class="flex items-center justify-between mt-0.5">
            <p class="text-sm flex-grow flex items-center">
                <span>IVA</span>
                <span class="flex-1 border-dashed border-b border-gray-400 mx-2"></span>
            </p>
            <span class="text-sm text-primary font-bold">{{ $this->cart?->taxTotal?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <div class="flex items-center justify-between mt-2">
            <p class="text-sm flex-grow flex items-center">
                <span>Total</span>
                <span class="flex-1 border-dashed border-b border-gray-400 mx-2"></span>
            </p>
            <span class="text-sm text-primary font-bold">{{ $this->cart?->total?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>

        <x-button link="{{ route('checkout') }}" class="btn btn-primary mt-4" label="Ir a Pagar" wire:navigate/>
        <div class="flex flex-col items-center justify-center">
            <x-button wire:click="$parent.$toggle('openCart')" class="btn btn-primary btn-link">Seguir comprando</x-button>
        </div>
    @endif
</div>

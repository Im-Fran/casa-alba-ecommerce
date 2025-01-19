<div class="flex items-center justify-center w-full gap-2" x-on:cart-updated.window="$wire.$refresh()">
    @if($this->inCart() > 0)
        <div class="flex items-center justify-between w-[90%] gap-2">
            <x-button wire:click.stop="removeFromCart" class="btn btn-primary btn-xs md:btn-md btn-circle text-neutral-50" icon="o-minus" spinner/>
            <span class="flex items-center justify-center text-xs md:text-lg text-primary border border-primary rounded-md w-full h-6 md:h-12 font-bold">{{ $this->inCart() }} en Carrito</span>
            <x-button wire:click.stop="addToCart" class="btn btn-primary btn-xs md:btn-md btn-circle text-neutral-50" icon="o-plus" spinner/>
        </div>
    @else
        <x-button wire:click.stop="addToCart" class="btn btn-xs md:btn-md {{ $this->stock > 0 ? 'btn-primary' : 'btn-disabled' }} w-[70%]">
            <span wire:target="addToCart" wire:loading.remove>{{ $this->stock > 0 ? 'Agregar al Carrito' : 'Sin Stock' }}</span>
            <x-loading class="loading-dots" wire:target="addToCart" wire:loading/>
        </x-button>
    @endif
</div>

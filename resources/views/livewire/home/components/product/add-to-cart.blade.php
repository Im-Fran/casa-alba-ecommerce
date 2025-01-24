<div class="flex items-center justify-center w-full px-2">
    @if($this->inCart() > 0)
        <div class="flex items-center justify-between w-[90%] gap-2">
            <x-button wire:click.stop="decrease" class="btn btn-primary {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm'  }} btn-circle text-neutral-50" icon="o-minus" spinner/>
            <span class="flex items-center justify-center text-xs md:text-lg text-primary border border-primary rounded-md w-full {{ $size == 'sm' ? 'h-6 md:h-8' : 'h-8' }} font-bold">{{ $this->inCart() }} en Carrito</span>
            <x-button wire:click.stop="increase" class="btn btn-primary {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm'  }} btn-circle text-neutral-50" icon="o-plus" spinner/>
        </div>
    @else
        <x-button wire:click.stop="increase" class="btn btn-sm {{ $this->stock > 0 ? 'btn-primary' : 'btn-disabled' }}" icon-right="o-shopping-cart" spinner>
            {{ $this->stock > 0 ? 'Agregar al Carro' : 'Sin Stock' }}
        </x-button>
    @endif
</div>

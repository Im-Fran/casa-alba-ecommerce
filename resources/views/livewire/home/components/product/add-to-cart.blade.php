<div class="flex items-center justify-center w-full px-2">
    @if($this->inCart() > 0)
        <div class="flex items-center justify-between w-full md:w-[90%] gap-2">
            <x-button wire:click.stop="decrease" class="btn btn-primary {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm'  }} btn-circle text-neutral-50" icon="o-minus" spinner/>
            <span class="flex items-center justify-center text-xs md:text-base text-primary-content border border-primary rounded-md w-full {{ $size == 'sm' ? 'h-6 md:h-8' : 'h-8' }} font-bold">{{ $this->inCart() }} en Carro</span>
            <x-button wire:click.stop="increase" class="btn btn-primary {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm'  }} btn-circle text-neutral-50" icon="o-plus" spinner/>
        </div>
    @elseif($this->stock === null)
        <x-button class="btn {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm' }} btn-disabled text-xs md:text-base">
            Cargando Stock <span class="loading loading-spinner w-5 h-5"/>
        </x-button>
    @elseif($this->stock === 0)
        <x-button class="btn {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm' }} btn-disabled text-xs md:text-base" icon-right="o-archive-box-x-mark">
            Sin Stock
        </x-button>
    @else
        <x-button wire:click.stop="increase" class="btn {{ $size == 'sm' ? 'btn-xs md:btn-sm' : 'btn-sm' }} text-xs md:text-base {{ $this->stock > 0 ? 'btn-primary' : 'btn-disabled' }}" icon-right="o-shopping-cart" spinner>
            {{ $this->stock > 0 ? 'Agregar al Carro' : 'Sin Stock' }}
        </x-button>
    @endif
</div>

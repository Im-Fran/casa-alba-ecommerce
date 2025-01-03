<div wire:poll.45s>
    <div wire:click.stop="$toggle('peek')" class="col-span-1 flex flex-col w-full hover:cursor-pointer hover:shadow-lg transition duration-300 ease-in-out rounded-lg p-2">
        <img
            src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
            alt="{{ $this->product->attr('name') }}"
            class="w-full rounded-xl border h-96 object-cover"
        />

        <div class="flex flex-col gap-2 mt-2">
            <div class="flex flex-col">
                <div class="flex justify-between items-center w-full gap-2">
                    <h3 class="text-xl text-primary font-medium">{{ $this->product->attr('name') }}</h3>
                    <h3 class="text-xl text-primary font-bold">${{ \Clemdesign\PhpMask\Mask::apply($this->product->prices()->first()->price->value, 'dot_separator.0') }}</h3>
                </div>
                <div class="flex justify-between items-center w-full gap-2">
                    <span class="text-neutral-600 max-w-lg">{{ $this->product->attr('descripcion-corta') }}</span>
                    <span class="text-neutral-400 font-semibold">{{ $this->stock > 0 ? ("{$this->stock} en") : 'Sin' }} Stock</span>
                </div>
            </div>
            <div class="flex items-center justify-between w-full gap-2">
                @if($this->inCart() > 0)
                    <x-button wire:click.stop="removeFromCart" class="btn-primary text-neutral-50">
                        <x-icon name="o-minus" wire:target="removeFromCart" wire:loading.remove/>
                        <x-loading class="loading-dots" wire:target="removeFromCart" wire:loading/>
                    </x-button>
                    <span class="flex items-center justify-center text-lg text-primary border border-primary rounded-md w-full h-12 font-bold">{{ $this->inCart() }} en Carrito</span>
                    <x-button wire:click.stop="addToCart" class="btn-primary text-neutral-50">
                        <x-icon name="o-plus" wire:target="addToCart" wire:loading.remove/>
                        <x-loading class="loading-dots" wire:target="addToCart" wire:loading/>
                    </x-button>
                @else
                    <x-button wire:click.stop="addToCart" class="{{ $this->stock > 0 ? 'btn-primary' : 'btn-disabled' }} text-neutral-50 w-full">
                        <span wire:target="addToCart" wire:loading.remove>
                            {{ $this->stock > 0 ? 'Agregar al Carrito' : 'Sin Stock' }}
                        </span>
                        <x-loading class="loading-dots" wire:target="addToCart" wire:loading/>
                    </x-button>
                @endif
            </div>
        </div>
    </div>

    <x-modal title="{{ $this->product->attr('name') }}" wire:model="peek" class="backdrop-blur">
        <div class="grid md:grid-cols-2 gap-5">
            <img
                src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
                alt="{{ $this->product->attr('name') }}"
                class="w-full rounded-xl border h-96 object-cover"
            />

            <div class="col-span-1 flex flex-col h-full gap-2.5">
                <div class="flex items-center justify-between w-full">
                    <span class="text-lg text-primary font-bold">${{ \Clemdesign\PhpMask\Mask::apply($this->product->prices()->first()->price->value, 'dot_separator.0') }}</span>

                    <span class="text-md text-neutral-400 font-semibold">
                        {{ $this->stock > 0 ? ("{$this->stock} en") : 'Sin' }} Stock
                    </span>
                </div>
                <span class="text-sm md:text-md text-neutral-600">{{ $this->product->attr('descripcion-corta') }}</span>
                <div class="text-sm md:text-md text-neutral-900">{!! $this->product->attr('description') !!}</div>
            </div>
        </div>

        <x-slot:actions>
            <x-button wire:click.stop="$toggle('peek')" class="btn-tertiary" label="Cerrar"/>
            <x-button class="btn-primary text-neutral-50" label="Ver Más"/>
        </x-slot:actions>
    </x-modal>

</div>

<div wire:poll.1m>
    <div wire:click.stop="$toggle('peek')" class="col-span-1 flex flex-col w-full hover:cursor-pointer hover:shadow-2xl transition duration-300 ease-in-out rounded-xl p-2">
        <div class="relative">
            <img
                src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
                alt="{{ $this->product->attr('name') }}"
                class="w-full rounded-xl border h-96 object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent p-2 rounded-xl border">
                <div class="absolute bottom-0 right-0">
                    <h3 class="text-2xl text-white font-bold p-2">${{ \Clemdesign\PhpMask\Mask::apply($this->product->prices()->first()->price->value, 'dot_separator.0') }}</h3>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 mt-2">
            <div class="flex flex-col">
                <h3 class="text-xl text-primary font-bold">{{ $this->product->attr('name') }}</h3>
                <span class="text-gray-500 max-w-lg text-md h-12">{{ $this->product->attr('descripcion-corta') }}</span>
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

    <livewire:home.components.product-card-modal wire:model="peek" :stock="$this->stock" :product="$this->product" />
</div>

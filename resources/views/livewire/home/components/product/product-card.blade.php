<div>
    <div wire:click.stop="$toggle('peek')" class="col-span-1 flex flex-col w-full hover:cursor-pointer hover:shadow-2xl transition duration-300 ease-in-out rounded-xl p-2 bg-neutral-50 border border-neutral-200">
        <div class="relative">
            <img
                src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first(['id', 'file_name', 'disk'])->getUrl() }}"
                alt="{{ $this->product->attr('name') }}"
                class="w-full rounded-xl border h-56 md:h-72 object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent p-2 rounded-xl border">
                <div class="absolute bottom-0 right-0">
                    <h3 class="text-2xl text-secondary font-semibold p-4">{{ $this->product->prices()->first()->price->unitFormatted('es-cl') }}</h3>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 mt-2">
            <div class="flex flex-col">
                <h3 class="text-xl text-primary font-bold">{{ $this->product->attr('name') }}</h3>
                <span class="text-gray-500 max-w-lg text-md h-12 line-clamp-2">{{ $this->product->attr('short_description') }}</span>
            </div>

            @if($this->hasVariants)
                <div class="flex items-center justify-center w-full px-2">
                    <x-button class="btn btn-primary btn-sm" icon-right="o-shopping-cart" spinner>Elegir Variante</x-button>
                </div>
            @else
                <livewire:home.components.product.add-to-cart wire:model="defaultVariant"/>
            @endif
        </div>
    </div>

    <livewire:home.components.product.product-card-modal wire:model="peek" :$product />

    @script
    <script>
        $wire.on('product-variant-updated.{{ $product->id }}', () => $wire.$refresh());
        Livewire.on('cart-updated', () => $wire.$refresh())
    </script>
    @endscript
</div>

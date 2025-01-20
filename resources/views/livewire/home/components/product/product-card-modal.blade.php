<x-modal wire:model="peek" class="backdrop-blur z-[999999]" box-class="md:w-[54rem] md:max-w-[54rem]">
    <div class="grid md:grid-cols-2 gap-5 mt-5">
        <img
            src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
            alt="{{ $this->product->attr('name') }}"
            class="w-full h-[28rem] rounded-xl border object-cover"
        />

        <div class="col-span-1 flex flex-col h-full justify-between gap-2.5">
            <div class="flex flex-col w-full">
                <div class="flex items-center justify-between gap-2.5 w-full">
                    <h2 class="text-2xl font-bold">{{ $this->product->attr('name') }}</h2>
                    <span class="text-md text-neutral-400 font-semibold">{{ $this->stock > 0 ? ("{$this->stock} en") : 'Sin' }} Stock</span>
                </div>
                <h3 class="text-xl text-primary font-semibold">${{ \Clemdesign\PhpMask\Mask::apply($this->product->prices()->first()->price->value, 'dot_separator.0') }}</h3>

                <span class="mt-2.5 text-sm text-neutral-500">{{ $this->product->attr('descripcion-corta') }}</span>
                <div class="text-sm md:text-md text-neutral-900 mt-2.5">{!! $this->product->attr('description') !!}</div>
            </div>

            <livewire:home.components.product.add-to-cart :product="$this->product"/>
        </div>
    </div>
</x-modal>

<x-modal wire:model="peek" class="backdrop-blur z-[999999]" box-class="w-[54rem] max-w-[54rem]" separator>
    <x-slot:title>{{ $this->product->attr('name') }}</x-slot:title>
    <x-slot:subtitle>{{ $this->product->attr('descripcion-corta') }}</x-slot:subtitle>

    <div class="grid md:grid-cols-2 gap-5">
        <img
            src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
            alt="{{ $this->product->attr('name') }}"
            class="w-full h-[28rem] rounded-xl border object-cover"
        />

        <div class="col-span-1 flex flex-col h-full gap-2.5">
            <div class="flex items-center justify-between w-full">
                <span class="text-lg text-primary font-bold">${{ \Clemdesign\PhpMask\Mask::apply($this->product->prices()->first()->price->value, 'dot_separator.0') }}</span>

                <span class="text-md text-neutral-400 font-semibold">
                        {{ $this->stock > 0 ? ("{$this->stock} en") : 'Sin' }} Stock
                    </span>
            </div>
            <div class="text-sm md:text-md text-neutral-900">{!! $this->product->attr('description') !!}</div>
        </div>
    </div>

    <x-slot:actions>
        <div class="w-full flex items-center justify-between">
            <x-button wire:click.stop="$toggle('peek')" class="btn-tertiary" label="Cerrar"/>
            <x-button class="btn-primary text-neutral-50" label="Ver Más"/>
        </div>
    </x-slot:actions>
</x-modal>

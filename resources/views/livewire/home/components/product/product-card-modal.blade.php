<x-modal wire:model="peek" class="backdrop-blur z-[10]" box-class="md:w-[54rem] md:max-w-[54rem]">
    <div class="grid md:grid-cols-2 gap-5 mt-5">
        <img
            src="{{ $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
            alt="{{ $this->product->attr('name') }}"
            class="w-full h-[28rem] rounded-xl border object-cover"
        />

        <div class="col-span-1 flex flex-col h-full justify-between gap-2.5" x-data="{ disableAddToCart: false }">
            <div class="flex flex-col w-full">
                <div class="flex items-center justify-between gap-2.5 w-full">
                    <h2 class="text-2xl font-bold">{{ $this->product->attr('name') }}</h2>
                    <span class="text-md text-neutral-400 font-semibold">{{ $this->selectedVariant->stock > 0 ? ("{$this->selectedVariant->stock} en") : 'Sin' }} Stock</span>
                </div>

                <h3 class="text-xl text-primary font-semibold">{{$this->selectedVariant->prices->first()->price->unitFormatted('es-cl')}}</h3>

                <span class="mt-2.5 text-sm text-neutral-500">{{ $this->product->attr('short_description') }}</span>
                <div class="text-sm md:text-md text-neutral-900 mt-2.5">{!! $this->product->attr('description') !!}</div>

                @if($this->productOptions->isNotEmpty())
                    <div class="mt-2.5">
                        @foreach($this->productOptions as $option)
                            <div class="flex flex-col mt-2.5" wire:key="product_option_{{ $option['option']->id }}">
                                <span class="text-lg font-medium">{{ $option['option']->translate('name') }}</span>

                                <div class="flex flex-wrap gap-2.5 mt-0.5"
                                    x-data="{ selectedOption: $wire.entangle('options').live, selectedValues: [] }"
                                    x-init="selectedValues = Object.values(selectedOption);
                                    $watch('selectedOption', value =>
                                        selectedValues = Object.values(selectedOption)
                                    )">
                                    @foreach($option['values'] as $value)
                                        <x-button wire:key="product_option_{{ $option['option']->id }}_value_{{ $value->id }}" class="btn btn-primary btn-outline btn-sm rounded-lg {{ $options->values()->contains($value->id) ? 'btn-active' : '' }}" x-on:click.stop="async () => { disableAddToCart = true; await $wire.$set('options.{{ $option['option']->id }}', {{ $value->id }}); disableAddToCart = false; }" spinner>
                                            {{ $value->translate('name') }}
                                        </x-button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-5 md:mt-0" x-show="!disableAddToCart">
                <livewire:home.components.product.add-to-cart size="md" wire:model="selectedVariant"/>
            </div>
            <div class="mt-5 md:mt-0" x-show="disableAddToCart">
                <div class="flex items-center justify-center w-full px-2">
                    <x-button class="btn btn-sm btn-disabled">Cargando Producto <span class="loading loading-spinner w-5 h-5"/></x-button>
                </div>
            </div>
        </div>
    </div>
</x-modal>

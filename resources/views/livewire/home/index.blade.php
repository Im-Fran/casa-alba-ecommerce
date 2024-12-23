<div>
    <livewire:home.components.banner-card/>


    <div class="h-full w-full min-h-screen">
        <!-- Products & Filters -->
        <section class="col-span-8 flex flex-col gap-5">
            <!-- Filters -->
            <div class="flex items-center justify-start gap-5">
                <x-dropdown label="{{ $this->collection?->attr('name') ?? 'Categoría' }}"
                            class="border border-gray-800">
                    <x-menu-item title="Todos" wire:click.stop="selectCollection(null)"/>
                    @foreach($collections as $collection)
                        <x-menu-item title="{{ $collection->attr('name') }}"
                                     wire:click.stop="selectCollection('{{ $collection->attr('name') }}')"/>
                    @endforeach
                </x-dropdown>

                <x-button icon-right="{{ $this->price === \App\Lib\Sort::DESC ? 'o-chevron-down' : 'o-chevron-up'  }}"
                          class="border border-gray-800 hover:border-gray-800" wire:click.stop="togglePrice()">
                    Precio {{ $this->price === \App\Lib\Sort::DESC ? 'Mayor a Menor' : 'Menor a Mayor' }}
                </x-button>
            </div>

            <!-- Products -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <div wire:key="{{$product->id}}" wire:click.stop="openPeekProduct({{ $product->id }})" class="col-span-1 flex flex-col w-full hover:cursor-pointer hover:shadow-lg transition duration-300 ease-in-out rounded-lg p-2">
                        <img
                            src="{{ $product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
                            alt="{{ $product->attr('name') }}"
                            class="w-full rounded-xl border h-96 object-cover"
                        />

                        <div class="flex flex-col gap-2 mt-2">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-center w-full gap-2">
                                    <h3 class="text-xl text-primary font-medium">{{ $product->attr('name') }}</h3>
                                    <h3 class="text-xl text-primary font-bold">
                                        ${{ \Clemdesign\PhpMask\Mask::apply($product->prices()->first()->price->value, 'dot_separator.0') }}</h3>
                                </div>
                                <span class="text-neutral-600">{{ $product->attr('descripcion-corta') }}</span>
                            </div>
                            <x-button wire:click.stop="addToCart({{ $product->id }})" class="btn-primary text-neutral-50" label="Agregar al Carrito"/>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <x-modal title="{{ $this->peekProduct() != null ? $this->peekProduct()->attr('name') : '' }}" wire:model="showProduct" class="backdrop-blur">
        @if($this->peekProduct())
            <div class="grid md:grid-cols-2 gap-5">
                <img
                    src="{{ $this->peekProduct()->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
                    alt="{{ $this->peekProduct()->attr('name') }}"
                    class="w-full rounded-xl border h-96 object-cover"
                />

                <div class="col-span-1 flex flex-col h-full gap-2.5">
                    <div class="flex items-center justify-between w-full">
                        <span class="text-lg text-primary font-bold">${{ \Clemdesign\PhpMask\Mask::apply($this->peekProduct()->prices()->first()->price->value, 'dot_separator.0') }}</span>

                        <span class="text-md text-neutral-400 font-semibold">
                            5 en Stock
                        </span>
                    </div>
                    <span class="text-sm md:text-md text-neutral-600">{{ $this->peekProduct()->attr('descripcion-corta') }}</span>
                    <div class="text-sm md:text-md text-neutral-900">{!! $this->peekProduct()->attr('description') !!}</div>
                </div>
            </div>

            <x-slot:actions>
                <x-button wire:click.stop="closePeekProduct" class="btn-tertiary" label="Cerrar"/>
                <x-button class="btn-primary text-neutral-50" label="Ver Más"/>
            </x-slot:actions>
        @else
            <h1 class="text-2xl font-bold mb-5">Producto no encontrado</h1>
        @endif
    </x-modal>
</div>

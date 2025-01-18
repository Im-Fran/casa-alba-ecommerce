<div>
    <livewire:home.components.banner-card/>


    <div id="productos" class="h-full w-full min-h-screen">
        <!-- Products & Filters -->
        <section class="col-span-8 flex flex-col gap-5">
            <!-- Filters -->
            <div class="flex items-center justify-start gap-5 p-2 md:p-0">
                <x-dropdown class="border border-gray-800">
                    <x-slot:label>{{ $this->collection?->attr('name') ?? 'Categoría' }}</x-slot:label>

                    <x-menu-item spinner="selectCollection" title="Todos" wire:click.stop="selectCollection(null)"/>
                    @foreach($collections as $collection)
                        <x-menu-item
                            spinner="selectCollection"
                            title="{{ $collection->attr('name') }}"
                            wire:click.stop="selectCollection('{{ $collection->attr('name') }}')"/>
                    @endforeach
                </x-dropdown>

                <x-button icon-right="{{ $this->price === \App\Lib\Sort::DESC ? 'o-chevron-down' : 'o-chevron-up'  }}" class="border border-gray-800 hover:border-gray-800" wire:click.stop="togglePrice()">
                    <span wire:target="togglePrice" wire:loading.remove>
                        Precio {{ $this->price === \App\Lib\Sort::DESC ? 'Mayor a Menor' : 'Menor a Mayor' }}
                    </span>
                    <x-loading class="loading-dots" wire:target="togglePrice" wire:loading/>
                </x-button>
            </div>

            <!-- Products -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <livewire:home.components.product-card :product="$product" wire:key="index_product_card_{{ $product->id }}"/>
                @endforeach
            </div>
        </section>
    </div>
</div>

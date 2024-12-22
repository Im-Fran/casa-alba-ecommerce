<div>
    <livewire:home.components.banner-card/>


    <div class="h-full w-full min-h-screen">
        <!-- Products & Filters -->
        <section class="col-span-8 flex flex-col gap-5">
            <!-- Filters -->
            <div class="flex items-center justify-start gap-5">
                <x-dropdown label="{{ $this->collection?->attr('name') ?? 'Categoría' }}" class="border border-gray-800">
                    <x-menu-item title="Todos" wire:click="selectCollection(null)"/>
                    @foreach($collections as $collection)
                        <x-menu-item title="{{ $collection->attr('name') }}" wire:click="selectCollection('{{ $collection->attr('name') }}')"/>
                    @endforeach
                </x-dropdown>

                <x-dropdown label="Precio" class="border border-gray-800">
                    <x-menu-item title="Menor a mayor"/>
                    <x-menu-item title="Mayor a menor"/>
                </x-dropdown>
            </div>

            <!-- Products -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <div class="col-span-1 flex flex-col w-full hover:cursor-pointer hover:shadow-lg transition duration-300 ease-in-out rounded-lg p-2">
                        <img
                            src="{{ $product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url }}"
                            alt="{{ $product->attr('name') }}"
                            class="w-full rounded-xl border h-96"
                        />

                        <div class="flex flex-col gap-2 mt-2">
                            <div class="flex flex-col">
                                <h3 class="text-xl text-primary font-medium">{{ $product->attr('name') }}</h3>
                                <span class="text-md text-neutral-600">{{ $product->attr('descripcion-corta') }}</span>
                                <p class="text-lg text-neutral-900 font-bold">${{ \Clemdesign\PhpMask\Mask::apply($product->prices()->first()->price->value, 'dot_separator.0') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>


    @script
    <script>
        window.addEventListener('livewire:init', function () {

        });
    </script>
    @endscript
</div>

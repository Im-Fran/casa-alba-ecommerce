<div>

    <livewire:components.navigation.header-component :sticky="true"/>


    <div class="pb-20 pt-[10rem]">
        <div id="banner" class="grid grid-cols-1 md:grid-cols-2 items-center justify-center w-full">
            <div class="absolute md:static col-span-1 flex flex-col items-center justify-center gap-5 z-[2] mt-[10rem] md:mt-0 inset-x-0">
                <h1 class="text-2xl md:text-8xl max-w-2xl font-bold text-center">Productos de Aseo para tu Hogar</h1>

                <x-button
                    class="btn btn-primary btn-sm md:btn-lg"
                    label="Comprar Ahora"
                    icon-right="o-arrow-down"
                    x-on:click="window.scrollTo({ top: window.screen.height/1.75, behavior: 'smooth' })"
                />
            </div>

            <img
                src="{{ asset('/images/productos_limpieza.webp') }}"
                alt="Productos de Limpieza"
                class="col-span-1 object-cover object-center w-full rounded-l-2xl blur-[5px] md:blur-0 z-[1]"
            />
        </div>
    </div>

    <div id="productos" class="container mx-auto h-full w-full min-h-screen">
        <!-- Title & Sort -->
        <section class="flex items-center justify-between border-b-2 mb-2.5 py-2 border-secondary w-full">
            <h2 class="text-2xl text-primary font-bold text-left">Productos</h2>

            <x-button icon-right="{{ $this->price === \App\Lib\Sort::DESC ? 'o-chevron-down' : 'o-chevron-up'  }}" class="btn btn-sm btn-primary btn-outline" wire:click.stop="togglePrice" spinner>
                Precio: {{ $this->price === \App\Lib\Sort::DESC ? 'Mayor a Menor' : 'Menor a Mayor' }}
            </x-button>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-12 gap-5">

            <!-- Filters -->
            <div class="col-span-2 flex flex-col items-start justify-start w-full gap-2">
                <div class="grid w-full">
                    <x-mary-input icon="o-magnifying-glass" wire:model.live="search" type="text" class="w-full p-2 bg-neutral-50 rounded-lg" placeholder="Buscar productos..."/>
                </div>

                <div class="flex flex-col items-start justify-start gap-2 bg-neutral-50 border rounded-lg p-2 w-full">
                    <div class="flex flex-col items-start justify-start gap-0.5 w-full">
                        <div class="flex flex-col items-start justify-start gap-2 p-2 w-full" x-data="{ open: true }">
                            <div class="flex items-center justify-between w-full cursor-pointer" @click="open = !open">
                                <h3 class="text-lg text-neutral-700">Categoría</h3>
                                <x-heroicon-o-plus x-bind:class="open ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 transition duration-300"/>
                            </div>

                            <div x-show="open" x-collapse class="w-full">
                                <x-menu>
                                    <x-menu-item title="Todos" wire:click.stop="selectCollection(null)" :active="$this->categoryId === null || $this->categoryId === ''" spinner/>
                                    @foreach(\Lunar\Models\Collection::whereNull('parent_id')->get() as $collection)
                                        @if($collection->children()->count() > 0)
                                            <x-menu-sub title="{{ $collection->attr('name') }}">
                                                <x-menu-item title="Todo {{ $collection->attr('name') }}" wire:click.stop="selectCollection({{ $collection->id }})" :active="$collection->id == $this->categoryId" spinner/>
                                                @foreach($collection->children()->get() as $subCollection)
                                                    <x-menu-item title="{{ $subCollection->attr('name') }}" wire:click.stop="selectCollection({{ $subCollection->id }})" :active="$subCollection->id == $this->categoryId" spinner/>
                                                @endforeach
                                            </x-menu-sub>
                                        @else
                                            <x-menu-item title="{{ $collection->attr('name') }}" wire:click.stop="selectCollection({{ $collection->id }})" :active="$collection->id == $this->categoryId" spinner/>
                                        @endif
                                    @endforeach
                                </x-menu>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Products -->
            <div class="col-span-1 md:col-span-10 grid grid-cols-2 lg:grid-cols-5 gap-5">
                @foreach($this->products as $product)
                    <livewire:home.components.product.product-card :product="$product" wire:key="index_product_card_{{ $product->id }}"/>
                @endforeach
            </div>
        </section>
    </div>

    <livewire:components.footer/>
</div>

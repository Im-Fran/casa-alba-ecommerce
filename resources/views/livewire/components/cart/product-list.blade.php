<div class="flex flex-col max-h-[70vh] overflow-y-scroll">
    @forelse(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
        <div wire:key="cart_line_{{$line->id}}" class="flex items-center justify-between p-4 border-b border-neutral-200">
            <div class="flex items-center space-x-4 h-full w-full">
                <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-14 h-20 object-cover object-center rounded-lg"/>
                <div class="flex flex-col items-start justify-between w-full h-full">
                    <div class="flex items-start justify-between w-full">
                        <div class="flex flex-col items-start justify-start">
                            <span class="text-lg font-semibold text-primary">{{ $line->purchasable->getDescription() }}</span>
                            @foreach($line->purchasable->values as $value)
                                <span class="text-sm text-neutral-500" wire:key="cart_line_{{ $line->id }}_option_{{ $value->id }}"><span class="text-sm text-neutral-800 font-medium">{{ $value->option->translate('name') }}</span>: {{ $value->translate('name') }}</span>
                            @endforeach
                        </div>
                        <div class="flex flex-col items-start justify-start">
                            <span class="text-lg font-medium text-primary">{{ $line->subTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                        </div>
                    </div>


                    <div class="flex items-center space-x-2">
                        <x-button x-data="{ loading: false }" x-on:click.stop="async () => { loading = true; await $wire.$parent.remFromCart({{ $line->id }}); loading = false; }" class="btn btn-xs btn-primary btn-circle" x-bind:class="{ 'btn-disabled': loading }" x-bind:disabled="loading">
                            <x-icon name="o-minus" class="w-5 h-5" x-show="!loading"/>
                            <span class="loading loading-spinner w-5 h-5" x-show="loading"/>
                        </x-button>
                        <span class="flex items-center justify-center text-xs md:text-md text-primary border border-primary rounded-md w-8 h-6 font-bold">{{ $line->quantity }}</span>
                        <x-button x-data="{ loading: false }" x-on:click.stop="async () => { loading = true; await $wire.$parent.addToCart({{ $line->id }}); loading = false; }" class="btn btn-xs btn-primary btn-circle" x-bind:class="{ 'btn-disabled': loading }" x-bind:disabled="loading">
                            <x-icon name="o-plus" class="w-5 h-5" x-show="!loading"/>
                            <span class="loading loading-spinner w-5 h-5" x-show="loading"/>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center w-full h-[70vh]">
            <x-lucide-shopping-cart class="w-16 h-16"/>

            <div class="flex flex-col items-center justify-center my-2.5">
                <h3 class="text-2xl text-center">Tu carrito está vacío</h3>
                <span class="text-lg text-center text-neutral-500">Agrega productos para comenzar a comprar</span>
            </div>

            <x-button wire:click="$parent.$toggle('openCart')" class="btn-primary btn-outline text-neutral-50 mt-4" label="Seguir Comprando"/>
        </div>
    @endforelse
</div>

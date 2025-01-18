<div class="flex flex-col max-h-[70vh]">
    @forelse(collect($this->cart?->lines ?: [])->sortByDesc('created_at') as $line)
        <div wire:key="cart_line_{{$line->id}}" class="flex items-center justify-between p-4 border-b border-neutral-200">
            <div class="flex items-center space-x-4">
                <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="h-20 object-cover rounded-lg"/>
                <div class="flex flex-col gap-2.5">
                    <div class="flex flex-col">
                        <h3 class="text-md">{{ $line->purchasable->getDescription() }}</h3>
                        <span class="text-sm text-neutral-500">{{ $line->purchasable->product->attr('descripcion-corta') }}</span>
                    </div>
                    <span class="text-sm">{{ $line->subTotal?->unitFormatted('es-cl') ?: '--' }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <x-button wire:click.stop="remFromCart({{$line->id}})" class="btn  btn-sm md:btn-md btn-primary btn-circle" icon="o-minus" spinner/>
                <span class="flex items-center justify-center text-sm md:text-lg text-primary border border-primary rounded-md w-8 h-8 md:w-12 md:h-12 font-bold">{{ $line->quantity }}</span>
                <x-button wire:click.stop="addToCart({{$line->id}})" class="btn  btn-sm md:btn-md btn-primary btn-circle" icon="o-plus" spinner/>
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center w-full h-[70vh]">
            <x-lucide-shopping-cart class="w-16 h-16"/>

            <div class="flex flex-col items-center justify-center my-2.5">
                <h3 class="text-2xl text-center">Tu carrito está vacío</h3>
                <span class="text-lg text-center text-neutral-500">Agrega productos para comenzar a comprar</span>
            </div>

            <x-button wire:click="$dispatch('closeCart')" class="btn-primary btn-outline text-neutral-50 mt-4" label="Seguir Comprando"/>
        </div>
    @endforelse
</div>

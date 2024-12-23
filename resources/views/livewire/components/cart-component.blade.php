<div>
    <x-drawer title="Carrito de Compras" wire:model="openCart" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[80vh] md:h-[90vh]" wire:poll.3s>
            <div class="flex flex-col max-h-[70vh]">
                @foreach($this->cart?->lines ?: [] as $line)
                    <div wire:key="cart_line_{{$line->id}}" class="flex items-center justify-between p-4 border-b border-neutral-200">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-16 h-16 object-cover rounded-lg"/>
                            <div class="flex flex-col gap-2.5">
                                <div class="flex flex-col">
                                    <h3 class="text-md">{{ $line->purchasable->getDescription() }}</h3>
                                    <span class="text-sm text-neutral-500">{{ $line->purchasable->product->attr('descripcion-corta') }}</span>
                                </div>
                                <span class="text-sm">{{ $line->subTotal?->unitFormatted('es-cl') ?: '--' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <x-button wire:click.stop="remFromCart({{$line->id}})" class="btn-primary text-neutral-50">
                                <x-icon name="o-minus" wire:target="remFromCart({{$line->id}})" wire:loading.remove/>
                                <x-loading class="loading-dots" wire:target="remFromCart({{$line->id}})" wire:loading/>
                            </x-button>
                            <span class="flex items-center justify-center text-lg text-primary border border-primary rounded-md w-12 h-12 font-bold">{{ $line->quantity }}</span>
                            <x-button wire:click.stop="addToCart({{$line->id}})" class="btn-primary text-neutral-50">
                                <x-icon name="o-plus" wire:target="addToCart({{$line->id}})" wire:loading.remove/>
                                <x-loading class="loading-dots" wire:target="addToCart({{$line->id}})" wire:loading/>
                            </x-button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col mt-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm">Sub Total</p>
                    <span class="text-sm">{{ $this->subTotal }}</span>
                </div>

                <div class="flex items-center justify-between mt-0.5">
                    <p class="text-sm">IVA</p>
                    <span class="text-sm">{{ $this->cart?->taxTotal?->unitFormatted('es-cl') ?: '--' }}</span>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <p class="text-sm">Total</p>
                    <span class="text-sm">{{ $this->cart?->total?->unitFormatted('es-cl') ?: '--' }}</span>
                </div>

                <x-button wire:click="checkout" class="btn-primary text-neutral-50 mt-4" label="Ir a Pagar"/>
            </div>
        </div>
    </x-drawer>

    <x-lucide-shopping-bag wire:click.stop="$toggle('openCart')" class="hover:text-primary w-6 h-6"/>
</div>

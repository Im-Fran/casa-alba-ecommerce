<div class="col-span-1 top-0 h-screen overflow-y-auto lg:overflow-y-visible static lg:sticky bg-primary pt-4 md:pt-10 px-10" x-on:cart-updated.window="$wire.$refresh()">
    <a href="{{ route('home') }}" class="flex items-center justify-start gap-2.5 text-lg font-semibold hover:underline transition pt-8 md:pt-16 pb-8">
        <x-heroicon-o-chevron-left class="w-6 h-6"/>
        <span>Seguir Comprando</span>
    </a>

    <div class="flex flex-col overflow-scroll h-[55vh] md:h-[65vh] container mx-auto">
        @foreach(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
            <div class="flex items-center justify-between p-1 md:p-4 {{ $this->cart->lines()->orderBy('id')->first()->id === $line->id ? '' : 'border-t' }} border-neutral-200">
                <div class="flex items-center space-x-4 h-full w-full">
                    <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-12 h-20 md:w-20 md:h-28 object-cover object-center rounded-lg"/>
                    <div class="flex flex-col items-start justify-between w-full h-full flex-grow">
                        <div class="flex items-start justify-between w-full h-full">
                            <div class="flex flex-col items-start h-full">
                                <div class="flex flex-col items-start justify-start">
                                    <span class="text-md md:text-lg font-semibold text-primary-content">{{ $line?->purchasable?->getDescription() }}</span>
                                    <span class="text-sm md:text-md font-medium text-primary-content"><span class="text-neutral-800 font-medium">{{ $line->quantity }} x </span> {{ $line->subTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                                </div>
                                <div class="flex flex-col">
                                    @foreach(collect($line->purchasable->values)->map(fn($it) => ['id' => $it->id, 'name' => $it->option->translate('name'), 'value' => $it->translate('name')]) as $opt)
                                        <span class="text-xs md:text-sm text-gray-300" wire:key="cart_line_{{ $line->id }}_option_{{ $opt['id'] }}">
                                            <span class="text-neutral-800 font-medium">{{ $opt['name'] }}</span>: {{ $opt['value'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center justify-start text-primary-content gap-2.5">
                                <span class="text-sm md:text-base cursor-pointer hover:underline transition" x-on:click.prevent="edit_line_{{ $line->id }}.showModal()">Editar</span>
                                <div class="w-[1.5px] h-4 md:h-6 bg-neutral-300"></div>
                                <x-lucide-trash class="w-5 h-5 inline cursor-pointer" wire:click.prevent="remove({{ $line->id }})" wire:target="remove({{ $line->id }})" wire:loading.class="hidden"/>
                                <x-loading class="w-5 h-5 hidden cursor-wait" wire:target="remove({{ $line->id }})" wire:loading.class="inline" wire:loading.class.remove="hidden"/>
                            </div>
                        </div>
                    </div>
                </div>

                <dialog x-data="{ quantity: {{ $line->quantity }} }" id="edit_line_{{ $line->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">Editar Cantidad</h3>
                        <x-form x-on:submit.prevent="async () => { $wire.edit({{ $line->id }}, quantity); await edit_line_{{ $line->id }}.close(); }" method="dialog" no-separator>
                            <div class="flex flex-col py-4">
                                <span>Por favor ingresa la cantidad de <b>{{ $line->purchasable->getDescription() }}</b> que deseas: </span>
                            </div>

                            <div class="flex flex-col w-full gap-1">
                                <x-label for="quantity">Cantidad</x-label>
                                <div class="flex">
                                    <input
                                        id="quantity"
                                        name="quantity"
                                        type="number"
                                        class="w-full p-2 border border-neutral-200 rounded-lg"
                                        x-model="quantity"
                                        min="1"
                                        step="1"
                                        max="{{ $line->purchasable->stock }}"
                                    />
                                </div>
                            </div>

                            <div class="modal-action">
                                <x-button class="btn-error text-neutral-800" label="Cancelar" x-on:click.stop="edit_line_{{ $line->id }}.close()"/>
                                <x-button type="submit" class="btn-primary" label="Guardar"/>
                            </div>
                        </x-form>
                    </div>
                </dialog>
            </div>
        @endforeach
    </div>

    <!-- Pricing details -->
    <div class="flex flex-col p-4 mt-4 container mx-auto">
        <div class="flex justify-between text-md font-medium text-neutral-800">
            <span>Sub Total</span>
            <span>{{ $this->subTotal }}</span>
        </div>
        <div class="flex justify-between text-md font-medium text-neutral-800">
            <span>IVA</span>
            <span>{{ $this->cart->taxTotal?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>
        <div class="flex justify-between text-md font-medium text-neutral-800">
            <span>Envío</span>
            <span>{{ $this->cart->shippingTotal?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>
        <div class="flex justify-between text-lg font-semibold text-primary-content mt-2">
            <span>Total</span>
            <span>{{ $this->cart->total?->unitFormatted('es-cl') ?? '--' }}</span>
        </div>
    </div>

</div>

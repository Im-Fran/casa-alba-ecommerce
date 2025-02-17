<div class="flex flex-col h-full overflow-scroll max-h-[65vh]">
    @foreach(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
        <div class="flex items-center justify-between p-4 {{ $this->cart->lines()->orderBy('id')->first()->id === $line->id ? '' : 'border-t' }} border-neutral-200">
            <div class="flex items-center space-x-4 h-full w-full">
                <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-20 h-28 object-cover object-center rounded-lg"/>
                <div class="flex flex-col items-start justify-between w-full h-full flex-grow">
                    <div class="flex items-start justify-between w-full h-full">
                        <div class="flex flex-col items-start h-full">
                            <div class="flex flex-col items-start justify-start">
                                <span class="text-lg font-semibold text-primary">{{ $line?->purchasable?->getDescription() }}</span>
                                <span class="text-md font-medium text-primary"><span class="text-md text-neutral-800 font-medium">{{ $line->quantity }} x </span> {{ $line->subTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                            </div>
                            <div class="flex flex-col">
                                @foreach(collect($line->purchasable->values)->map(fn($it) => ['id' => $it->id, 'name' => $it->option->translate('name'), 'value' => $it->translate('name')]) as $opt)
                                    <span class="text-sm text-neutral-500" wire:key="cart_line_{{ $line->id }}_option_{{ $opt['id'] }}">
                                <span class="text-sm text-neutral-800 font-medium">{{ $opt['name'] }}</span>: {{ $opt['value'] }}
                            </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-start justify-start text-primary gap-2.5">
                            <span class="cursor-pointer hover:underline transition" x-on:click.prevent="edit_line_{{ $line->id }}.showModal()">Editar</span>
                            <div class="w-[1.5px] h-6 bg-neutral-300"></div>
                            <span x-data="{ loading: false }" class="flex items-center justify-center gap-2 cursor-pointer hover:underline transition" x-on:click.prevent="async () => { if(loading) {return;} loading = true; await $wire.remove({{ $line->id }}); await $wire.$refresh(); loading = false; }">Eliminar <x-loading x-show="loading" class="w-4 h-4"/></span>
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
                            <x-button class="btn-error text-neutral-50" label="Cancelar" x-on:click.stop="edit_line_{{ $line->id }}.close()"/>
                            <x-button type="submit" class="btn-primary" label="Guardar"/>
                        </div>
                    </x-form>
                </div>
            </dialog>
        </div>
    @endforeach
</div>

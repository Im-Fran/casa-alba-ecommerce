<div class="flex items-center justify-between p-4 border-b border-neutral-200 flex-grow">
    <div class="flex items-center space-x-4 h-full w-full">
        <img src="{{ $image }}" alt="Product Image" class="w-20 h-28 object-cover object-center rounded-lg"/>
        <div class="flex flex-col items-start justify-between w-full h-full flex-grow">
            <div class="flex items-start justify-between w-full h-full">
                <div class="flex flex-col items-start h-full">
                    <div class="flex flex-col items-start justify-start">
                        <span class="text-lg font-semibold text-primary">{{ $name }}</span>
                        <span class="text-md font-medium text-primary"><span class="text-md text-neutral-800 font-medium">{{ $quantity }} x </span> {{ $price }}</span>
                    </div>
                    <div class="flex flex-col">
                        @foreach($options as $opt)
                            <span class="text-sm text-neutral-500" wire:key="cart_line_{{ $lineId }}_option_{{ $opt['id'] }}">
                                <span class="text-sm text-neutral-800 font-medium">{{ $opt['name'] }}</span>: {{ $opt['value'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-start justify-start text-primary gap-2.5">
                    <span class="cursor-pointer hover:underline transition" wire:click.prevent="openModal">Editar</span>
                    <div class="w-[1.5px] h-6 bg-neutral-300"></div>
                    <span class="cursor-pointer hover:underline transition" wire:click.prevent="$parent.remove({{ $lineId }})">Eliminar</span>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ quantity: $wire.entangle('newQuantity').live }">
        <x-modal wire:model="showEditModal" class="backdrop-blur-md">
            <div class="flex flex-col mb-5">
                <span>Por favor ingresa la cantidad de {{ $name }} que deseas: </span>
                <span class="text-xs">Si la cantidad es <b>0</b>, será eliminado del carrito.</span>
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
                        x-on:blur="$wire.set('newQuantity', quantity)"
                    />
                </div>
            </div>

            <x-slot:actions>
                <x-button class="btn-error text-neutral-50" label="Cancelar" wire:click="$toggle('showEditModal')"/>
                <x-button class="btn-primary" label="Guardar" x-on:click="async () => { await $wire.$parent.edit({{ $lineId }}, {{ $newQuantity }}); await $wire.$parent.$refresh(); await $wire.$toggle('showEditModal'); $wire.$dispatch('updated') }"/>
            </x-slot:actions>
        </x-modal>
    </div>
</div>

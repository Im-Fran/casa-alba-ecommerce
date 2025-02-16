<div class="flex flex-col h-full">

    @foreach(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
        <div wire:key="cart_line_{{$line->id}}" class="flex items-center justify-between p-4 border-b border-neutral-200 flex-grow">
            <div class="flex items-center space-x-4 h-full w-full">
                <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-20 h-28 object-cover object-center rounded-lg"/>
                <div class="flex flex-col items-start justify-between w-full h-full flex-grow">
                    <div class="flex items-start justify-between w-full h-full">
                        <div class="flex flex-col items-start h-full">
                            <div class="flex flex-col items-start justify-start">
                                <span class="text-lg font-semibold text-primary">{{ $line->purchasable->getDescription() }}</span>
                                <span class="text-md font-medium text-primary"><span class="text-md text-neutral-800 font-medium">{{ $line->quantity }} x </span> {{ $line->subTotal?->unitFormatted('es-cl') ?? '--' }}</span>
                            </div>
                            <div class="flex flex-col">
                                @foreach($line->purchasable->values as $value)
                                    <span class="text-sm text-neutral-500" wire:key="cart_line_{{ $line->id }}_option_{{ $value->id }}">
                                    <span class="text-sm text-neutral-800 font-medium">{{ $value->option->translate('name') }}</span>: {{ $value->translate('name') }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-start justify-start text-primary gap-2.5">
                            <span class="cursor-pointer hover:underline transition">Editar</span>
                            <div class="w-[1.5px] h-6 bg-neutral-300"></div>
                            <span class="cursor-pointer hover:underline transition" wire:click.stop="remove({{ $line->id }})">Eliminar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

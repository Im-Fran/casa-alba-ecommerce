<div class="flex flex-col">
    @foreach(($this->cart?->lines ?? []) as $line)
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
                </div>
            </div>
        </div>
    @endforeach
</div>

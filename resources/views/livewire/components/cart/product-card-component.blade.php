<div class="flex items-center justify-between p-4 border-b border-neutral-200">
    <div class="flex items-center space-x-4">
        <img src="{{ $line->purchasable->getThumbnail()->getUrl() }}" alt="Product Image" class="w-16 h-16 object-cover rounded-lg"/>
        <div class="flex flex-col gap-2.5">
            <div class="flex flex-col">
                <h3 class="text-md">{{ $line->purchasable->getDescription() }}</h3>
                <span class="text-sm text-neutral-500">{{ $line->purchasable->getDescription() }}</span>
            </div>
            <span class="text-sm">{{ $line->subTotal->unitFormatted('es-cl') }}</span>
        </div>
    </div>
</div>

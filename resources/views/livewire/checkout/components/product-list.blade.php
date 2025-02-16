<div class="flex flex-col h-full">
    @foreach(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
        <livewire:checkout.components.product-list.product-card
            wire:key="cart_line_{{$line->id}}"
            :line-id="$line->id"
            :quantity="$line->quantity"
            :name="$line->purchasable->getDescription()"
            :image="$line->purchasable->getThumbnail()->getUrl()"
            :price="$line->subTotal?->unitFormatted('es-cl') ?? '--'"
            :options="collect($line->purchasable->values)->map(fn($it) => ['id' => $it->id, 'name' => $it->option->translate('name'), 'value' => $it->translate('name')])->toArray()"
            @updated="$refresh()"
        />
    @endforeach
</div>

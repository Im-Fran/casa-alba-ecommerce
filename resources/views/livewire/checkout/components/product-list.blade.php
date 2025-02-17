<div class="flex flex-col h-full">
    @foreach(collect($this->cart?->lines ?? [])->sortBy('id') as $line)
        <livewire:checkout.components.product-list.product-card
            wire:key="product_card_{{ $line->purchasable->id }}_cart_line_{{$line->id}}"
            :$line
        />
    @endforeach
</div>

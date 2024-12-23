<img
    src="{{ $this->imageUrl() }}"
    alt="{{ $this->product?->attr('name') ?: $this->variant?->attr('name') }}"
    class="w-full rounded-xl border h-96 object-cover"
/>

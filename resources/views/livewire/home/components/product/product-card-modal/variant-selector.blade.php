<div class="mt-2.5">
    @foreach($this->product->productOptions as $option)
        <div class="flex flex-col mt-2.5" wire:key="product_option_{{ $option->id }}">
            <span class="text-lg font-medium">{{ $option->translate('name') }}</span>

            <div class="flex flex-wrap gap-2.5 mt-0.5">
                @foreach($option->values as $value)
                    <x-button class="btn btn-primary btn-outline btn-sm rounded-lg {{ $this->options->contains(fn($opt) => $opt->id === $value->id) ? 'btn-active' : '' }}" wire:click.stop="$parent.toggleOption({{ $value->id }})" spinner>
                        {{ $value->translate('name') }}
                    </x-button>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

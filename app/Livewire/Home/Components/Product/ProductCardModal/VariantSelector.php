<?php

namespace App\Livewire\Home\Components\Product\ProductCardModal;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;

class VariantSelector extends Component {
    public Product $product;

    public ?ProductVariant $selectedVariant;

    #[Reactive]
    public Collection $options;

    public function render(): View {
        return view('livewire.home.components.product.product-card-modal.variant-selector');
    }
}

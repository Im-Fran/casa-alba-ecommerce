<?php

namespace App\Livewire\Home\Components\Product;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Lunar\Models\Product;

class ProductCardModal extends Component {

    #[Modelable]
    public bool $peek = false;

    #[Reactive]
    public int $stock;

    #[Reactive]
    public Product $product;

    public function render(): View {
        return view('livewire.home.components.product.product-card-modal');
    }
}

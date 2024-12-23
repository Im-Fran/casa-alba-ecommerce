<?php

namespace App\Livewire\Home\Components;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;

class ProductImageComponent extends Component {

    public ?Product $product = null;
    public ?ProductVariant $variant = null;

    #[Computed]
    public function imageUrl(): string {

        if($this->variant != null) {
            return $this->variant->image_url ?: $this->variant->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url;
        }

        if($this->product != null) {
            return $this->product->images()->whereJsonContains('custom_properties->primary', true)->first()->original_url;
        }

        return '#';
    }

    public function render() {
        return view('livewire.home.components.product-image-component');
    }
}

<?php

namespace App\Livewire\Home\Components\Product;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;

class ProductCard extends Component {
    public bool $peek = false;

    public Product $product;
    public ProductVariant $defaultVariant;

    public function mount(Product $product): void {
        $this->product = $product;
        $this->defaultVariant = $product->variants()->where('stock', '>=', 0)->first();

        $this->dispatch("product-variant-updated.{$this->product->id}");
    }

    #[Computed]
    public function stock(): int {
        return $this->defaultVariant->stock;
    }

    #[Computed]
    public function hasVariants(): bool {
        return $this->product->variants()->count(['id']) > 1;
    }

    #[Computed]
    public function inCart(): int {
        $cart = CartSession::current();
        if ($cart == null) {
            return 0;
        }

        return $cart->lines->whereIn('purchasable_id', $this->product->variants()->pluck('id'))->sum('quantity');
    }
}

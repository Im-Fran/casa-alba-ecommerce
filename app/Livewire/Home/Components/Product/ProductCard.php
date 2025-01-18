<?php

namespace App\Livewire\Home\Components\Product;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Product;
use Masmerise\Toaster\Toaster;

class ProductCard extends Component {

    public bool $peek = false;
    public Product $product;

    #[Computed]
    public function stock(): int {
        return $this->defaultVariant->stock;
    }

    #[Computed]
    public function defaultVariant(): mixed {
        return $this->product->variants()->first();
    }

    #[Computed]
    public function inCart(): int {
        $cart = CartSession::current();
        if($cart == null) {
            return 0;
        }

        return $cart->lines->whereIn('purchasable_id', $this->product->variants()->pluck('id'))->sum('quantity');
    }

    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.home.components.product.product-card');
    }
}

<?php

namespace App\Livewire\Home\Components\Product;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;

class ProductCardModal extends Component {
    #[Modelable]
    public bool $peek = true;

    public Product $product;

    public ?ProductVariant $selectedVariant;

    public Collection $options;

    #[Locked]
    public bool $hasProductOptions = false;

    private function selectVariant(): void {
        $this->selectedVariant = $this->productVariants->first(fn ($variant) => !$variant->values->pluck('id')->diff(($this->options ?? ($this->productOptions->mapWithKeys(fn ($it) => [$it['option']->id => $it['values']->first()->id])))->values())->count());

        if (!$this->selectedVariant) {
            abort(404);
        }
    }

    #[Computed]
    public function productVariants(): Collection {
        return $this->product->variants;
    }

    #[Computed]
    public function productOptionValues(): Collection {
        return $this->productVariants->pluck('values')->flatten();
    }

    #[Computed]
    public function productOptions(): Collection {
        $opts = $this->productOptionValues->unique('id')->groupBy('product_option_id')
            ->map(fn ($it) => [
                'option' => $it->first()->option,
                'values' => $it,
            ])
            ->values();

        $this->hasProductOptions = $opts->isNotEmpty();
        return $opts;
    }

    public function addToCart(): void {
        CartSession::add($this->selectedVariant);
    }

    public function updated(): void {
        $this->selectVariant();
    }

    public function mount(): void {
        $this->options = $this->productOptions->mapWithKeys(fn ($it) => [$it['option']->id => $it['values']->first()->id]);
        $this->selectVariant();
    }
}

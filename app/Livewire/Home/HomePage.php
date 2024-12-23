<?php

namespace App\Livewire\Home;

use App\Lib\Sort;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Collection;
use Lunar\Models\Product;

#[Title('Inicio')]
class HomePage extends Component {

    #[Url(as: 'categoria', history: true)]
    public ?string $categoryName = null;

    #[Url(as: 'precio', history: true)]
    public Sort $price = Sort::ASC;

    public bool $showProduct = false;
    public ?int $productId = null;

    #[Computed]
    public function collection(): Collection|null {
        return $this->categoryName != null ? Collection::query()
            ->whereJsonContains('attribute_data->name->value->es', $this->categoryName)
            ->first() : null;
    }

    #[Computed]
    public function peekProduct(): Product|null {
        return Product::find($this->productId);
    }

    public function openPeekProduct(int $id): void {
        $this->productId = $id;
        $this->showProduct = true;
    }

    public function closePeekProduct(): void {
        $this->showProduct = false;
        $this->productId = null;
    }

    public function selectCollection(?string $categoryName): void {
        $this->categoryName = $categoryName;
    }

    public function togglePrice(): void {
        $this->price = $this->price === Sort::ASC ? Sort::DESC : Sort::ASC;
    }

    public function render(): Application|Factory|\Illuminate\Contracts\View\View|View {
        $products = ($this->collection?->products() ?: Product::query())
            ->select('lunar_products.*', DB::raw('MIN(lunar_prices.price) as min_price'))
            ->status('published')
            ->joinRelation('variants.prices')
            ->where('lunar_prices.priceable_type', 'product_variant')
            ->groupBy('lunar_products.id')
            ->orderBy('min_price', $this->price->value)
            ->paginate(12);

        return view('livewire.home.index', [
            'collections' => Collection::all(),
            'products' => $products,
        ]);
    }
}

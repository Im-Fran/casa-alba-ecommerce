<?php

namespace App\Livewire\Home;

use App\Lib\Sort;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Collection;
use Lunar\Models\Product;

#[Title('Inicio')]
class HomePage extends Component {

    #[Url(as: 'categoria', history: true, keep: false, except: '')]
    public ?string $categoryId = null;

    #[Url(as: 'precio', history: true)]
    public Sort $price = Sort::ASC;

    #[Computed]
    public function collection(): ?Collection {
        return $this->categoryId != null && intval($this->categoryId) != 0 ? Collection::find(intval($this->categoryId)) : null;
    }

    public function selectCollection(?string $categoryId): void {
        $this->categoryId = $categoryId;
    }

    public function togglePrice(): void {
        $this->price = $this->price === Sort::ASC ? Sort::DESC : Sort::ASC;
        $this->dispatch('toggle-price');
    }

    public function render(): View {
        $collectionProducts = ($this->collection?->products()?->pluck('product_id') ?: collect());

        $this->collection?->children()?->get()?->flatMap(fn($it) => $it->products()->pluck('product_id'))->each(fn($it) => $collectionProducts->push($it));

        $products = Product::query()
            ->select('lunar_products.*', DB::raw('MIN(lunar_prices.price) as min_price'))
            ->when($collectionProducts->isNotEmpty(), fn($query) => $query->whereIn('lunar_products.id', $collectionProducts))
            ->status('published')
            ->joinRelation('variants.prices')
            ->where('lunar_prices.priceable_type', 'product_variant')
            ->groupBy('lunar_products.id')
            ->orderBy('min_price', $this->price->value)
            ->paginate(12);

        return view('livewire.home.index', [
            'collections' => Collection::whereNull('parent_id')->get(),
            'products' => $products,
        ]);
    }
}

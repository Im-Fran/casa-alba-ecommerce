<?php

namespace App\Livewire\Home;

use App\Lib\Sort;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Product;

#[Title('Inicio')]
class HomePage extends Component {

    #[Url(as: 'busqueda', history: true, keep: false, except: '')]
    public ?string $search = null;

    #[Url(as: 'categoria', history: true, keep: false, except: '')]
    public ?string $categoryId = null;

    #[Url(as: 'precio', history: true)]
    public Sort $price = Sort::ASC;

    public function selectCollection(?string $categoryId): void {
        $this->categoryId = $categoryId;
    }

    public function togglePrice(): void {
        $this->price = $this->price === Sort::ASC ? Sort::DESC : Sort::ASC;
        $this->dispatch('toggle-price');
    }

    #[Computed]
    public function products(): LengthAwarePaginator {
        return Product::query()
            ->select('lunar_products.*', DB::raw('MIN(lunar_prices.price) as min_price'))
            ->when($this->categoryId, function ($query) {
                $query->whereIn('lunar_products.id', function ($subQuery) {
                    $subQuery->select('product_id')
                        ->from('lunar_collection_product')
                        ->whereIn('collection_id', function ($subSubQuery) {
                            $subSubQuery->select('id')
                                ->from('lunar_collections')
                                ->where('id', $this->categoryId)
                                ->orWhere('parent_id', $this->categoryId);
                        });
                });
            })
            ->when($this->search, fn($query) => $query
                ->whereRaw("translate(LOWER(lunar_products.attribute_data->'name'->>'value'), 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') LIKE ?", [strtolower("%$this->search%")])
                ->orWhereRaw("translate(LOWER(lunar_products.attribute_data->'description'->>'value'), 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') LIKE ?", [strtolower("%$this->search%")])
                ->orWhereRaw("translate(LOWER(lunar_products.attribute_data->'short_description'->>'value'), 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') LIKE ?", [strtolower("%$this->search%")])
            )
            ->status('published')
            ->joinRelation('variants.prices')
            ->where('lunar_prices.priceable_type', 'product_variant')
            ->groupBy('lunar_products.id')
            ->orderBy('min_price', $this->price->value)
            ->paginate(12);
    }
}

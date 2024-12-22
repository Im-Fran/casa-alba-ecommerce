<?php

namespace App\Livewire\Home;

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

    #[Computed]
    public function collection() {
        return $this->categoryName != null ? Collection::query()
            ->whereJsonContains('attribute_data->name->value->es', $this->categoryName)
            ->first() : null;
    }

    public function selectCollection(?string $categoryName): void {
        $this->categoryName = $categoryName;
    }


    public function render(): Application|Factory|\Illuminate\Contracts\View\View|View {
        $products = ($this->collection?->products() ?: Product::query())
            ->paginate(12);
        return view('livewire.home.index', [
            'collections' => Collection::all(),
            'products' => $products,
        ]);
    }
}

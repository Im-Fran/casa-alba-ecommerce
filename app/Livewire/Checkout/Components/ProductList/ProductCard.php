<?php

namespace App\Livewire\Checkout\Components\ProductList;

use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductCard extends Component {

    #[Locked]
    public string $name, $image, $price;

    #[Locked]
    public int $quantity, $lineId;

    #[Locked]
    public array $options;

    public bool $showEditModal = false;
    public int $newQuantity = 1;

    public function openModal(): void {
        $this->newQuantity = $this->quantity;
        $this->showEditModal = true;
    }

}

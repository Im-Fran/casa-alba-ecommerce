<?php

namespace App\Livewire\Checkout\Components\ProductList;

use Livewire\Component;
use Lunar\Models\CartLine;

class ProductCard extends Component {

    public ?CartLine $line = null;
}

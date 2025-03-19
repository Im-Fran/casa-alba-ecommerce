<?php

namespace App\Livewire\Checkout;

use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Order;

class CancelPage extends Component {

    #[Url(as: 'order')]
    public Order $order;
}

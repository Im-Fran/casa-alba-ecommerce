<?php

namespace App\Livewire\Checkout;

use App\Lib\VentiPay;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Order;

class CancelPage extends Component {

    #[Url(as: 'order')]
    public Order $order;

    public function retry(): void {
        $data = app(VentiPay::class)->getCheckout($this->order);
        redirect()->away($data['url']);
    }
}

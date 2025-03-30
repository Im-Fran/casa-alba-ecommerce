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
        $data = app(VentiPay::class)->getCheckout(id: $this->order->meta['ventipay_checkout_id']);
        redirect()->away($data['url']);
    }
}

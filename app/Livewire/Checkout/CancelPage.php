<?php

namespace App\Livewire\Checkout;

use App\Lib\MercadoPago;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Order;
use Mockery\Exception;
use Usernotnull\Toast\Concerns\WireToast;

class CancelPage extends Component {

    use WireToast;

    #[Locked]
    #[Url(as: 'status', keep: true)]
    public string $status;

    #[Locked]
    #[Url(as: 'external_reference', keep: true)]
    public int $externalReference;

    public Order $order;

    public function mount(): void {
        $this->order = Order::find($this->externalReference);
    }

    public function retry(): void {
        try {
            $checkoutUrl = app(MercadoPago::class)
                ->getCheckoutUrl(preference_id: $this->order->meta['mercadopago_pref_id']);
            redirect()->away($checkoutUrl);
        } catch (Exception) {
            toast()->danger('Error al intentar reintentar el pago. Por favor, inténtalo más tarde.')->push();
        }
    }
}

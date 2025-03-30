<?php

namespace App\Livewire\Checkout;

use App\Lib\VentiPay;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Order;
use Usernotnull\Toast\Concerns\WireToast;
use function Sentry\captureException;

class SuccessPage extends Component {

    use WireToast;

    #[Url(as: 'order')]
    public Order $order;

    public function mount(): void {
        // From here (and if rendered because of the signature) we know the payment was successful, so now we validate it.
        try {
            $checkout = app(VentiPay::class)
                ->getCheckout(id: $this->order->meta['ventipay_checkout_id'], query: ['expand[]' => 'payment_method']);
        } catch (\Exception $e) {
            captureException($e);
            toast()->danger($e->getMessage(), '¡Error al Contactar VentiPay!')->push();
            return;
        }

        if($this->order->transactions()->whereReference($checkout['id'])->first()?->status !== $checkout['status']) {
            $this->order->transactions()->create([
                'type' => 'capture',
                'success' => true,
                'driver' => 'ventipay',
                'amount' => $checkout['amount'],
                'reference' => $checkout['id'],
                'status' => $checkout['status'],
                'card_type' => $checkout['payment_method']['brand'],
                'last_four' => $checkout['payment_method']['last4'],
            ]);

            $statuses = [
                'paid' => 'payment-received',
            ];

            $this->order->update([
                'status' => $statuses[$checkout['status']] ?? 'awaiting-payment',
            ]);

            // Empty cart since the order was successful
            CartSession::forget();
        }
    }
}

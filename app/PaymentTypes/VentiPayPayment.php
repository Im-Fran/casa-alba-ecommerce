<?php

namespace App\PaymentTypes;

use App\Lib\VentiPay;
use Exception;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class VentiPayPayment extends AbstractPayment {

    /**
     * @throws Exception
     */
    public function authorize(): ?PaymentAuthorize {
        if (!$this->order) {
            if (!$this->order = $this->cart->order) {
                $this->order = $this->cart->createOrder();
            }
        }

        if ($this->order->placed_at) {
            // ¡Ocurrió un error!
            $failure = new PaymentAuthorize(
                success: false,
                message: 'Esta orden ya fue generada!',
                orderId: $this->order?->id,
                paymentType: 'ventipay',
            );

            PaymentAttemptEvent::dispatch($failure);

            return $failure;
        }

        try {
            $redirectUri = app(VentiPay::class)->createCheckout(order: $this->order);
        } catch (\Exception $e){
            $failure = new PaymentAuthorize(
                success: false,
                message: $e->getMessage(),
                orderId: $this->order?->id,
                paymentType: 'ventipay'
            );

            PaymentAttemptEvent::dispatch($failure);
            return $failure;
        }

        // TODO
        return null;
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund {
        // TODO: Implement refund() method.
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture {
        // TODO: Implement capture() method.
    }
}

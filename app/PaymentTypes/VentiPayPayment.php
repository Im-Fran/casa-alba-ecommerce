<?php

namespace App\PaymentTypes;

use App\Lib\VentiPay;
use Exception;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Models\Contracts\Transaction;
use Lunar\PaymentTypes\AbstractPayment;
use function Sentry\captureException;
use function Sentry\captureMessage;

class VentiPayPayment extends AbstractPayment {

    /**
     * @throws Exception
     */
    public function authorize(): ?PaymentAuthorize {
        $this->order = $this->order ?: $this->cart->createOrder();

        if ($this->order->placed_at) {
            // ¡Ocurrió un error!
            $failure = new PaymentAuthorize(
                success: false,
                message: 'Esta orden ya fue generada!',
                orderId: $this->order?->id,
                paymentType: 'ventipay',
            );

            PaymentAttemptEvent::dispatch($failure);
            captureMessage("Intento de pago duplicado");

            return $failure;
        }

        try {
            app(VentiPay::class)->createCheckout(order: $this->order);
        } catch (Exception $e){
            captureException($e);
            $failure = new PaymentAuthorize(
                success: false,
                message: $e->getMessage(),
                orderId: $this->order?->id,
                paymentType: 'ventipay'
            );

            PaymentAttemptEvent::dispatch($failure);
            return $failure;
        }

        $success = new PaymentAuthorize(
            success: true,
            message: 'Redirigiendo a VentiPay...',
            orderId: $this->order?->id,
            paymentType: 'ventipay',
        );

        PaymentAttemptEvent::dispatch($success);
        return $success;
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund {
        $checkoutId = $transaction->order->meta['ventipay_checkout_id'];

        // Get the checkout
        try {
            $checkout = app(VentiPay::class)
                ->getCheckout(id: $checkoutId);
        } catch (Exception $e) {
            captureException($e);

            return new PaymentRefund(
                success: false,
                message: $e->getMessage(),
            );
        }

        if($amount > intval($checkout['available_for_refund'])) {
            return new PaymentRefund(
                success: false,
                message: 'El monto a reembolsar es mayor al disponible. Monto disponible: ' . $checkout['available_for_refund'],
            );
        }

        try {
            $refund = app(VentiPay::class)
                ->refundCheckout(id: $checkoutId, amount: $amount);
        } catch (Exception $e) {
            captureException($e);

            return new PaymentRefund(
                success: false,
                message: $e->getMessage(),
            );
        }

        if($refund['status'] === 'paid') {
            return new PaymentRefund(
                success: true,
                message: 'Reembolso exitoso',
            );
        }
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture {
        // TODO: Implement capture() method.
    }
}

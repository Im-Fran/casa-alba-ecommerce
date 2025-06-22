<?php

namespace App\PaymentTypes;

use App\Lib\MercadoPago;
use Exception;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;
use function Sentry\captureException;
use function Sentry\captureMessage;

class MercadoPagoPayment extends AbstractPayment {

    public function authorize(): ?PaymentAuthorize {
        $this->order = $this->order ?: $this->cart->createOrder();

        if ($this->order->placed_at) {
            // ¡Ocurrió un error!
            $failure = new PaymentAuthorize(
                success: false,
                message: 'Esta orden ya fue generada!',
                orderId: $this->order?->id,
                paymentType: 'mercadopago',
            );


            PaymentAttemptEvent::dispatch($failure);
            captureMessage("Intento de pago duplicado");
            return $failure;
        }

        try {
            app(MercadoPago::class)
                ->createPreference(order: $this->order);
            
            $success = new PaymentAuthorize(
                success: true,
                message: 'Redirigiendo a Mercado Pago...',
                orderId: $this->order?->id,
                paymentType: 'mercadopago',
            );
            PaymentAttemptEvent::dispatch($success);
            return $success;
        } catch (Exception $e) {
            captureException($e);
            $failure = new PaymentAuthorize(
                success: false,
                message: $e->getMessage(),
                orderId: $this->order?->id,
                paymentType: 'mercadopago'
            );

            PaymentAttemptEvent::dispatch($failure);
            return $failure;
        }
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture {
        // TODO: Implement capture() method.
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        // TODO: Implement refund() method.
    }
}

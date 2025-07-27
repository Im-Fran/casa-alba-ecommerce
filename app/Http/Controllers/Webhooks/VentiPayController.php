<?php

namespace App\Http\Controllers\Webhooks;

use App\Lib\VentiPay;
use App\Mail\Checkout\CheckoutRefundMail;
use App\Mail\Checkout\CheckoutSuccessMail;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;
use function Sentry\captureException;

class VentiPayController {

    public function __invoke(Request $request) {
        $type = $request->type;

        return match ($type) {
            'checkout.paid' => $this->checkoutPaid(request: $request),
            'checkout.refunded' => $this->checkoutRefunded(request: $request),
            default => response()->json([
                'error' => "Webhook type '{$type}' not found"
            ]),
        };

    }

    private function checkoutRefunded(Request $request): JsonResponse {
        $data = $request->json('data');
        $order = Order::where('meta->ventipay_checkout_id', $data['id'])->firstOrFail();
        try {
            $checkout = app(VentiPay::class)
                ->getCheckout(id: $order->meta['ventipay_checkout_id'], query: ['expand[]' => 'payment_method']);
        } catch (\Exception $e) {
            captureException($e);
            toast()->danger($e->getMessage(), '¡Error al Contactar VentiPay!')->push();
            return response()->json([
                'error' => 'Error al contactar VentiPay',
            ], 500);
        }

        $previouslyRefunded = ($order->transactions()
            ->where('type', 'refund')
            ->sum('amount') ?? 0);

        $transaction = $order->transactions()->create([
            'type' => 'refund',
            'success' => true,
            'driver' => 'ventipay',
            'amount' => ($data['refunded_amount'] - $previouslyRefunded),
            'reference' => $checkout['id'],
            'status' => $data['refunded_amount'] >= $data['original_amount'] ? 'refunded' : 'partially-refunded',
            'card_type' => $checkout['payment_method']['brand'],
            'last_four' => $checkout['payment_method']['last4'],
        ]);

        $order->update([
            'status' => $transaction->status,
        ]);

        /** @var OrderAddress $billing */
        $billing = $order->billingAddress()->first();
        Mail::to($billing->contact_email)
            ->send(new CheckoutRefundMail(order: $order, billing_address: $billing, transaction: $transaction));

        return response()->json([
            'status' => 'ok',
            'message' => 'Se ha reembolsado el pago y notificado al cliente.',
        ]);
    }

    private function checkoutPaid(Request $request): JsonResponse {
        $data = $request->json('data');
        $order = Order::where('meta->ventipay_checkout_id', $data['id'])->firstOrFail();
        try {
            $checkout = app(VentiPay::class)
                ->getCheckout(id: $order->meta['ventipay_checkout_id'], query: ['expand[]' => 'payment_method']);
        } catch (\Exception $e) {
            captureException($e);
            toast()->danger($e->getMessage(), '¡Error al Contactar VentiPay!')->push();
            return response()->json([
                'error' => 'Error al contactar VentiPay',
            ], 500);
        }

        $order->update([
            'status' => 'payment-received',
            'placed_at' => Carbon::parse($data['paid_at']),
            'customer_reference' => $data['customer']['id'],
        ]);

        $order->transactions()->create([
            'type' => 'capture',
            'success' => true,
            'driver' => 'ventipay',
            'amount' => $checkout['amount'],
            'reference' => $checkout['id'],
            'status' => $checkout['status'],
            'card_type' => $checkout['payment_method']['brand'],
            'last_four' => $checkout['payment_method']['last4'],
        ]);

        /** @var OrderAddress $billing */
        $billing = $order->billingAddress()->first();
        Mail::to($billing->contact_email)
            ->send(new CheckoutSuccessMail(order: $order, billing_address: $billing));

        return response()->json([
            'status' => 'ok',
            'message' => 'Se ha recibido el pago y notificado al cliente.',
        ]);
    }
}

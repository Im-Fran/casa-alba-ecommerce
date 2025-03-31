<?php

namespace App\Http\Controllers\Webhooks;

use App\Notifications\Checkout\CheckoutSuccessNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;

class VentiPayController {

    public function __invoke(Request $request) {
        $type = $request->type;

        return match ($type) {
            'checkout.paid' => $this->checkoutPaid(request: $request),
            default => response()->json([
                'error' => "Webhook type '{$type}' not found"
            ]),
        };

    }

    private function checkoutPaid(Request $request): JsonResponse {
        $data = $request->json('data');
        $order = Order::where('meta->ventipay_checkout_id', $data['id'])->firstOrFail();
        $order->update([
            'status' => 'payment-received',
            'placed_at' => Carbon::parse($data['paid_at']),
            'customer_reference' => $data['customer']['id'],
        ]);

        /** @var OrderAddress $billing */
        $billing = $order->billingAddress()->first();
        Notification::route('mail', $billing->contact_email)
            ->notifyNow(new CheckoutSuccessNotification(order: $order, billing_address: $billing));

        return response()->json([
            'status' => 'ok',
            'message' => 'Se ha recibido el pago y notificado al cliente.',
        ]);
    }
}

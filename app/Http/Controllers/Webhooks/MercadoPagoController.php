<?php

namespace App\Http\Controllers\Webhooks;

use App\Lib\MercadoPago;
use App\Mail\Checkout\CheckoutSuccessMail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lunar\Models\OrderAddress;

class MercadoPagoController
{

    public function __invoke(Request $request) {
        $type = $request->type;

        return match ($type) {
            'payment' => $this->payment(request: $request),
            default => tap(response()->json([
                'error' => "Webhook type '{$type}' not found"
            ]), function ($response) use ($type, $request) {
                Log::warning('Unknown MercadoPago webhook type', [
                    'type' => $type,
                    'request' => $request->all(),
                ]);

                return $response;
            }),
        };
    }

    private function payment(Request $request) {
        $data_id = $request->data_id;
        $payment = app(MercadoPago::class)
            ->getPayment($data_id);

        if ($payment['status'] === 'approved') {
            $order = Order::find($payment['external_reference']);

            $order->update([
                'status' => 'payment-received',
                'placed_at' => Carbon::parse($payment['approved_at']),
                'customer_reference' => $payment['payer_id'],
            ]);

            $order->transactions()->create([
                'type' => 'capture',
                'success' => true,
                'driver' => 'mercadopago',
                'amount' => $payment['total_paid'],
                'reference' => $payment['id'],
                'status' => 'payment-received',
                'card_type' => $payment['card_type'],
                'last_four' => $payment['card_last_four'],
            ]);

            /** @var OrderAddress $billing */
            $billing = $order->billingAddress()->first();
            Mail::to($billing->contact_email)
                ->send(new CheckoutSuccessMail(order: $order, billing_address: $billing));
        }

        return response()->json(['message' => 'Payment processed successfully']);
    }

}

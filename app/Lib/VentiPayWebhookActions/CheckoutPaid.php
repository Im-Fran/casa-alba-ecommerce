<?php

namespace App\Lib\VentiPayWebhookActions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lunar\Models\Order;

class CheckoutPaid extends WebhookAction {

    public function handle(Request $request): Response {
        $data = $request->json('data')->all();
        $order = Order::where('meta->ventipay_checkout_id', $data['id'])->firstOrFail();
        $order->update([
            'status' => 'payment-received',
            'placed_at' => Carbon::parse($data['paid_at']),
        ]);

        return response();
    }
}

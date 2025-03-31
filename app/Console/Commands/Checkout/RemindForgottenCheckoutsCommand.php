<?php

namespace App\Console\Commands\Checkout;

use App\Notifications\Checkout\ForgottenCheckoutNotification;
use Illuminate\Console\Command;
use Lunar\Models\Address;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;
use Notification;

const META_NOTIFICATION_KEY = 'last_forgotten_notification';

class RemindForgottenCheckoutsCommand extends Command {
    protected $signature = 'checkout:remind-forgotten-checkouts';
    protected $description = 'Sends a reminder to the customers about forgotten checkouts.';

    public function handle(): void {
        $orders = Order::whereStatus('awaiting-payment')
            ->whereHas('billingAddress')
            ->whereNotNull('meta->ventipay_checkout_id')
            ->where(fn($q) => $q->whereNull("meta->" . META_NOTIFICATION_KEY)->orWhere('meta->' . META_NOTIFICATION_KEY, '<', now()->subDay()))
            ->pluck('id');

        if ($orders->isEmpty()) {
            $this->info('No hay pedidos pendientes de pago.');
            return;
        }

        foreach ($orders as $orderId) {
            $order = Order::find($orderId);
            if($order == null) {
                $this->error("No se encontró el pedido {$orderId}.");
                continue;
            }

            /** @var OrderAddress $billing */
            $billing = $order->billingAddress()->first();
            if($billing == null) {
                $this->error("No se encontró la dirección de facturación para el pedido {$orderId}.");
                continue;
            }

            // Send reminder notification
            Notification::route('mail', $billing->contact_email)
                ->notifyNow(new ForgottenCheckoutNotification(order: $order, billingAddress: $billing));

            // Update the last notification time
            $order->meta[META_NOTIFICATION_KEY] = now();
            $order->save();

            $this->info("Recordatorio enviado para el pedido {$orderId}.");
        }
    }
}

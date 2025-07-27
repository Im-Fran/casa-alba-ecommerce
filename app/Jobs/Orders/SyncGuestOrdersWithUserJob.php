<?php

namespace App\Jobs\Orders;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Lunar\Models\Order;

class SyncGuestOrdersWithUserJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly User $user
    ){}

    public function handle(): void {
        $order = Order::whereNull('customer_id')
            ->whereHas('billingAddress', function ($query) {
                $query->where('contact_email', $this->user->email);
            })
            ->pluck('id');

        if ($order->isEmpty()) {
            return;
        }

        $customer = $this->user->selfCustomer();

        $order->each(function ($orderId) use ($customer) {
            $order = Order::find($orderId);
            $order->update(['customer_id' => $customer->id]);
            $order->addresses->each(function ($address) use ($customer){
                $address->update(['customer_id' => $customer->id]);
            });
        });
    }
}

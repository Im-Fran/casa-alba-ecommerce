<?php

namespace App\Models;

use Lunar\Models\Order as LunarOrder;

class Order extends LunarOrder {

    protected static function booted(): void {
        static::updated(function ($order) {
            if ($order->isDirty('status')) {

                if ($order->status === 'payment-received') {
                    foreach ($order->lines as $line) {

                        if ($line->type === 'shipping') {
                            continue;
                        }

                        $purchasable = $line->purchasable;

                        if ($purchasable && $purchasable->stock >= $line->quantity) {
                            $purchasable->stock -= $line->quantity;
                            $purchasable->save();
                        }
                    }
                }


                if ($order->getOriginal('status') === 'payment-received' && $order->status === 'awaiting-payment') {
                    foreach ($order->lines as $line) {

                        if ($line->type === 'shipping') {
                            continue;
                        }

                        $purchasable = $line->purchasable;

                        if ($purchasable) {
                            $purchasable->stock += $line->quantity;
                            $purchasable->save();
                        }
                    }
                }
            }
        });
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lunar\Models\Order;

class CheckoutController {

    public function success(Order $order, Request $request) {
        dd([$order->toArray(),$request->all()]);
    }

    public function cancel(Order $order, Request $request) {
        dd([$order->toArray(),$request->all()]);
    }
}

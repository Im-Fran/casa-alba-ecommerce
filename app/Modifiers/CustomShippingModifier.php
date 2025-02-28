<?php

namespace App\Modifiers;

use Closure;
use Lunar\Base\ShippingModifier;
use Lunar\DataTypes\Price;
use Lunar\DataTypes\ShippingOption;
use Lunar\Facades\ShippingManifest;
use Lunar\Models\Cart;
use Lunar\Models\TaxClass;

class CustomShippingModifier extends ShippingModifier {

    public function handle(Cart $cart, Closure $next): mixed {
        $taxClass = TaxClass::first();

        ShippingManifest::addOption(new ShippingOption(
            name: 'Despacho a Domicilio',
            description: 'Recibe tu compra en tu domicilio',
            identifier: 'home_delivery',
            price: new Price(5000, $cart->currency, 1),
            taxClass: $taxClass,
        ));

        ShippingManifest::addOption(new ShippingOption(
            name: 'Retiro en Tienda',
            description: 'Retira tu compra en nuestra tienda',
            identifier: 'store_pickup',
            price: new Price(0, $cart->currency, 1),
            taxClass: $taxClass,
            collect: true,
        ));

        return $next($cart);
    }
}

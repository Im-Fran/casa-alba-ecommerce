<?php

namespace App\Providers;

use App\Helpers\TurnstileClient;
use App\Lib\MercadoPago;
use App\Lib\VentiPay;
use App\Models\Order;
use App\Modifiers\CustomShippingModifier;
use App\PaymentTypes\MercadoPagoPayment;
use App\PaymentTypes\VentiPayPayment;
use Illuminate\Support\ServiceProvider;
use Lunar\Admin\Support\Facades\LunarPanel;
use Lunar\Base\ShippingModifiers;
use Lunar\Facades\ModelManifest;
use Lunar\Facades\Payments;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        MercadoPagoConfig::setRuntimeEnviroment(app()->isProduction() ? MercadoPagoConfig::SERVER : MercadoPagoConfig::LOCAL);

        LunarPanel::register();

        $this->app->singleton(TurnstileClient::class, fn() => new TurnstileClient(secret: config('services.turnstile.secret')));
        $this->app->singleton(VentiPay::class, fn() => new VentiPay(privateKey: config('services.ventipay.private_key')));

        $this->app->singleton(PreferenceClient::class, fn() => new PreferenceClient());
        $this->app->singleton(PaymentClient::class, fn() => new PaymentClient());
        $this->app->singleton(MercadoPago::class, fn() => new MercadoPago());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ShippingModifiers $modifiers): void {
        $modifiers->add(CustomShippingModifier::class);
        ModelManifest::replace(\Lunar\Models\Contracts\Order::class, Order::class);

        Payments::extend('ventipay', fn($app) => $app->make(VentiPayPayment::class));
        Payments::extend('mercadopago', fn($app) => $app->make(MercadoPagoPayment::class));
    }
}

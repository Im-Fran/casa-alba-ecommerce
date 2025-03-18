<?php

namespace App\Providers;

use App\Helpers\TurnstileClient;
use App\Lib\VentiPay;
use App\Modifiers\CustomShippingModifier;
use App\PaymentTypes\VentiPayPayment;
use Illuminate\Support\ServiceProvider;
use Lunar\Admin\Support\Facades\LunarPanel;
use Lunar\Base\ShippingModifiers;
use Lunar\Facades\Payments;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        LunarPanel::register();

        $this->app->singleton(TurnstileClient::class, fn() => new TurnstileClient(secret: config('services.turnstile.secret')));
        $this->app->singleton(VentiPay::class, fn() => new VentiPay(privateKey: config('services.ventipay.private_key')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ShippingModifiers $modifiers): void {
        $modifiers->add(CustomShippingModifier::class);

        Payments::extend('ventipay', fn($app) => $app->make(VentiPayPayment::class));
    }
}

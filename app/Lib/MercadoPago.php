<?php

namespace App\Lib;

use Exception;
use Illuminate\Support\Facades\Log;
use Lunar\Models\Address;
use Lunar\Models\Order;
use Lunar\Models\OrderLine;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

readonly class MercadoPago {

    /**
     * @throws Exception
     */
    public function createPreference(Order $order): string {
        /** @var Address $billingAddress */
        $billingAddress = $order->billingAddress;

        $items = $order->lines->map(function (OrderLine $line) {
            return [
                'title' => $line->description,
                'quantity' => $line->quantity,
                'unit_price' => $line->unit_price->value,
            ];
        })->toArray();

        $preference = app(PreferenceClient::class)->create([
            'items' => $items,
            'payer' => [
                'name' => $billingAddress->first_name,
                'surname' => $billingAddress->last_name,
                'email' => $billingAddress->contact_email,
                'address' => [
                    'street_name' => $billingAddress->line_one,
                    'zip_code' => $billingAddress->postcode,
                ],
            ],
            'back_urls' => [
                'success' => route('checkout.success'),
                'failure' => route('checkout.cancel'),
            ],
            'auto_return' => 'approved',
            'statement_descriptor' => 'CASAALBA',
            'external_reference' => $order->id,
        ]);
        Log::debug("Preferencia de pago creada en Mercado Pago", [
            'preference_id' => $preference->id,
            'order_id' => $order->id,
            'response' => $preference,
        ]);

        if(!$preference->id) {
            throw new Exception('Error al crear la preferencia de pago en Mercado Pago');
        }

        if($order->meta == null) {
            $order->meta = [
                'mercadopago_pref_id' => $preference->id,
            ];
        } else {
            $order->meta['mercadopago_pref_id'] = $preference->id;
        }

        $order->save();

        return app()->isProduction() ? $preference->init_point : $preference->sandbox_init_point;
    }

    /**
     * @param string $preference_id
     * @return string
     * @throws MPApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCheckoutUrl(string $preference_id): string {
        $pref = app(PreferenceClient::class)->get(id: $preference_id);
        if (!$pref->init_point) {
            throw new Exception('Error al obtener la URL de pago de Mercado Pago');
        }

        return app()->isProduction() ? $pref->init_point : $pref->sandbox_init_point;
    }

    /**
     * @param int $payment_id
     * @return array
     * @throws ContainerExceptionInterface
     * @throws MPApiException
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function getPayment(int $payment_id): array {
        $payment = app(PaymentClient::class)->get(id: $payment_id);
        if (!$payment) {
            throw new Exception('Error al obtener el pago de Mercado Pago');
        }

        return [
            'id' => $payment->id,
            'status' => $payment->status,
            'external_reference' => $payment->external_reference,
            'total_paid' => $payment->transaction_details->total_paid_amount,
            'approved_at' => $payment->date_approved,
            'payer_id' => $payment->payer->id,
            'payment_method_id' => $payment->card->id ?? $payment->payment_method_id,
            'card_type' => $payment->payment_method_id,
            'card_last_four' => $payment->card->last_four_digits,
        ];
    }
}

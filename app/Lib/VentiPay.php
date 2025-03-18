<?php

namespace App\Lib;

use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Lunar\Models\Address;
use Lunar\Models\Order;
use Lunar\Models\OrderLine;

const VENTIPAY_ENDPOINT = 'https://api.ventipay.com';

readonly class VentiPay {

    public function __construct(
        private string $privateKey
    ){}


    public function baseHttpClient(): PendingRequest|Factory {
        return Http::baseUrl(VENTIPAY_ENDPOINT)->withBasicAuth($this->privateKey, '');
    }

    /**
     * @throws Exception
     */
    public function getOrCreateCustomerId(string $email, string $name, string $last_name, string $rut) {
        $response = $this->baseHttpClient()
            ->withBody(json_encode([
                'email' => $email,
                'country' => 'CL',
                'first_name' => $name,
                'last_name' => $last_name,
                'taxid' => $rut,
                'metadata' => [
                    'rut' => $rut,
                ]
            ]))
            ->throw()
            ->post('/v1/customers')
            ->json();

        // Ensure the user has the ventipay_id if it already exists.
        if($customer = User::whereRut($rut)->first()?->selfCustomer()) {
            $customer->meta['ventipay_id'] = $response['id'];
            $customer->save();
        }

        return $customer->meta['ventipay_id'];
    }

    /**
     * Generate a new checkout.
     *
     * $items should have the format:
     * [
     *      'unit_price' => 1000,
     *      'quantity' => 1,
     *      'name' => 'Product name',
     *      'sku' => 'Product SKU',
     * ]
     * @throws Exception
     */
    public function createCheckout(Order $order) {
        $items = $order->productLines->map(fn(OrderLine $it) => [
            'unit_price' => $it->unit_price->value,
            'quantity' => $it->quantity,
            'sku' => $it->purchasable->sku,
            'name' => $it->description,
        ]);

        /** @var Address $billingAddress */
        $billingAddress = $order->billingAddress;

        $customerId = $this->getOrCreateCustomerId(
            email: $billingAddress->contact_email,
            name: $billingAddress->first_name,
            last_name: $billingAddress->last_name,
            rut: $billingAddress->meta['rut'],
        );

        $response = $this->baseHttpClient()
            ->withBody(json_encode([
            'currency' => 'clp',
            'authorize' => true,
            'cancel_url_method' => 'post',
            'cancel_url' => route('checkout.success', ['order' => $order->id]),
            'success_url_method' => 'post',
            'success_url' => route('checkout.cancel', ['order' => $order->id]),
            'items' => $items,
            'customer_id' => $customerId,
            'external_id' => $order->id,
        ]))
            ->throw()
            ->post('/v1/checkout')
            ->json();

        $order->meta['ventipay_checkout_id'] = $response['id'];
        $order->save();

        return $response['url'];
    }

}

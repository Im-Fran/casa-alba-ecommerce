<?php

namespace App\Lib;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

const VENTIPAY_ENDPOINT = 'https://api.ventipay.com';

class VentiPay {

    private Client $client;

    public function __construct(string $privateKey){
        $authorizationHeader = base64_encode("$privateKey:");
        $this->client = new Client([
            'base_uri' => VENTIPAY_ENDPOINT,
            'headers' => [
                'Authorization' => "Basic $authorizationHeader",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function getOrCreateCustomerId(string $email, string $name, string $last_name, string $rut) {
        $clientResponse = $this->client->post('/v1/customers', [
            'json' => [
                'email' => $email,
                'country' => 'CL',
                'first_name' => $name,
                'last_name' => $last_name,
                'taxid' => $rut,
                'metadata' => [
                    'rut' => $rut,
                ]
            ],
        ]);
        $response = json_decode($clientResponse->getBody()->getContents(), true);

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
     */
    public function createCheckout(string $order_id, string $customer_id, array $items) {
        $response = $this->client->post('/v1/checkouts', [
            'json' => [
                'currency' => 'clp',
                'authorize' => true,
                'cancel_url_method' => 'get',
                'cancel_url' => route('checkout', ['cancel']),
                'items' => $items,
                'customer_id' => $customer_id,
                'external_id' => $order_id,
                'success_url_method' => 'get',
                'success_url' => route('checkout.success', ['success']),
            ]
        ]);

        dd($response);
    }

}

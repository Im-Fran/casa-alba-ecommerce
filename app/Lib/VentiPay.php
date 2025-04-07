<?php

namespace App\Lib;

use App\Models\User;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Lunar\DataTypes\ShippingOption;
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

        return $customer?->meta['ventipay_id'] ?? $response['id'];
    }

    /**
     * Gets the payment intent for the given payment id.
     *
     * @param string $id
     * @return array|mixed
     * @throws ConnectionException
     */
    public function getPaymentIntent(string $id) {
        return $this->baseHttpClient()
            ->asJson()
            ->throw()
            ->get("/v1/payments/$id")
            ->json();
    }

    /**
     * Creates a new payment intent
     */
    public function createPaymentIntent(Order $order) {
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
                'amount' => $order->total,
                'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
                'success_url' => route('checkout.success', ['order' => $order->id]),
                'capture' => true,
                'currency' => 'clp',
                'customer_id' => $customerId,
                'custom_fields' => [
                    $billingAddress->first_name,
                    $billingAddress->last_name,
                    $billingAddress->line_one,
                    $billingAddress->contact_phone,
                    $billingAddress->meta['rut'],
                ]
            ]))
            ->throw()
            ->post('/v1/payments')
            ->json();

        return $response['id'];
    }

    /**
     * Gets the checkout for the given order.
     *
     * @param string $id The id of the checkout
     * @param array|null $query Additional query parameters.
     * @return array
     * @throws ConnectionException
     */
    public function getCheckout(string $id, ?array $query = null): array {
        return $this->baseHttpClient()
            ->asJson()
            ->throw()
            ->get("/v1/checkouts/$id", $query)
            ->json();
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
        $items = $order->lines->map(fn(OrderLine $it) => [
            'unit_price' => $it->unit_price->value,
            'quantity' => $it->quantity,
            'sku' => $it->purchasable_type === ShippingOption::class ? 'shipping' : ($it->purchasable?->sku ?? 'N/A'),
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
                'success_url' => URL::temporarySignedRoute('checkout.success', now()->addHour(), ['order' => $order->id]),
                'success_url_method' => 'get',
                'cancel_url' => URL::temporarySignedRoute('checkout.cancel', now()->addHour(), ['order' => $order->id]),
                'cancel_url_method' => 'get',
                'items' => $items,
                'customer_id' => $customerId,
                'external_id' => $order->id,
            ]))
            ->throw()
            ->post('/v1/checkouts')
            ->json();

        if($order->meta == null) {
            $order->meta = [
                'ventipay_checkout_id' => $response['id']
            ];
        } else {
            $order->meta['ventipay_checkout_id'] = $response['id'];
        }
        $order->save();

        return $response['url'];
    }

    /**
     * Refunds the given checkout. If used electronic transfer you can't refund to payment method but the customer balance.
     *
     * @param string $id The id for the checkout
     * @param string $method The payment method of the checkout. Defaults to 'payment_method'. (payment_method|customer_balance)
     * @param int|null $amount The amount to refund. If null, the maximum amount will be refunded.
     * @return array|mixed
     * @throws ConnectionException
     */
    public function refundCheckout(string $id, string $method = 'payment_method', int $amount = null): mixed {
        return $this->baseHttpClient()
            ->withBody(json_encode([
                'destination' => $method,
                'amount' => $amount,
            ]))
            ->throw()
            ->post("/v1/checkouts/$id/refund")
            ->json();
    }
}

<?php

namespace App\Helpers;

use Filament\Support\Colors\Color;

class TransactionText {

    private static array $cachedStatusColor = [];

    public static function getLabel(string $status): string {
        return match ($status) {
            'paid' => 'Pagado',
            'pending' => 'Pendiente',
            'refunded' => 'Reembolsado',
            'partially-refunded' => 'Reembolsado Parcialmente',
            'cancelled' => 'Cancelado',
            'dispatched' => 'Despachado',
            'payment-offline' => 'Pago Presencial',
            'payment-received' => 'Pago Recibido',
            'awaiting-payment' => 'Esperando Pago',
            'awaiting-shipment' => 'Esperando Despacho',
            'awaiting-fulfillment' => 'Esperando Cumplimiento',
            'awaiting-pickup' => 'Esperando Retiro',
            default => $status,
        };
    }

    public static function getColor(string $status): array {
        $color = match ($status) {
            'paid', 'payment-received' => '#6a67ce',
            'pending', 'awaiting-pickup', 'awaiting-fulfillment', 'awaiting-shipment', 'awaiting-payment' => '#848a8c',
            'refunded', 'partially-refunded', 'cancelled' => '#d9534f',
            'dispatched', 'payment-offline' => '#0A81D7',
            default => '#000000',
        };

        return static::$cachedStatusColor[$status] ??= Color::hex($color);
    }
}

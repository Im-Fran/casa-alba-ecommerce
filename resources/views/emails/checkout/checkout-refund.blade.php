<x-mail::message>
# ¡Hola {{ $billing_address->first_name }}!

Te informamos que se ha procesado un reembolso para tu pedido en **{{ config('app.name') }}**.

## Detalles del reembolso
<x-mail::panel>
- **Número de pedido:** {{ $order->id }}
- **Fecha de reembolso:** {{ $transaction->created_at->format('d/m/Y H:i') }}
- **Monto reembolsado:** {{ $transaction->amount->unitFormatted('es-cl') }}
- **Estado:** {{ \App\Helpers\TransactionText::getLabel($transaction->status) }}
</x-mail::panel>

## Información del pago
<x-mail::panel>
- **Método de pago:** {{ ucfirst(strtolower($transaction->card_type)) }}
- **Últimos 4 dígitos:** {{ $transaction->last_four }}
</x-mail::panel>

## Datos de la orden
<x-mail::panel>
- **Nombre:** {{ $billing_address->first_name }} {{ $billing_address->last_name }}
- **Dirección:** {{ $billing_address->line_one }}
@if($billing_address->line_two)
- **Dirección adicional:** {{ $billing_address->line_two }}
@endif
- **Ciudad:** {{ $billing_address->city }}
- **País:** {{ $billing_address->country->name }}
- **Código postal:** {{ $billing_address->postcode }}
- **Teléfono:** {{ $billing_address->contact_phone }}
</x-mail::panel>

Si tienes alguna pregunta sobre este reembolso, no dudes en contactarnos a través de nuestra página de contacto.

Gracias por tu comprensión.
</x-mail::message>

<x-mail::message>
# ¡Hola {{ $billing_address->first_name }}!

Gracias por tu compra en **{{ config('app.name') }}**. Tu pedido ha sido recibido y está siendo procesado.


## Resumen de tu pedido
<x-mail::panel>
- **Número de pedido:** {{ $order->id }}
- **Fecha de compra:** {{ $order->created_at->format('d/m/Y H:i') }}
- **Total:** {{ $order->total->unitFormatted('es-cl') }}
- **Estado:** {{ $order->status_label }}
</x-mail::panel>

## Datos de Envío
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

Puedes ver el estado de tu pedido y más detalles en tu cuenta de cliente en nuestro sitio web.
Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos a través de nuestra página de contacto.

Gracias por elegir **{{ config('app.name') }}**. Esperamos verte de nuevo pronto.
</x-mail::message>

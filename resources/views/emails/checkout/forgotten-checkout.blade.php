<x-mail::message>
# ¡Hola {{ $billing_address->first_name }}!

Este es un recordatorio de que tienes un pedido pendiente de pago. Si quieres continuar con el pedido puedes presionar el botón de abajo.

<x-mail::button :url="$action_url">
Completar Pedido
</x-mail::button>

Si no deseas continuar con el pedido, puedes ignorar este mensaje, no se te cobrará nada y el pedido se cancelará automáticamente en 90 días.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>

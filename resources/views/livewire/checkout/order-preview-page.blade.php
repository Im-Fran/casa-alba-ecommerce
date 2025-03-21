<div class="min-h-screen flex flex-col">
                                    <livewire:components.navigation.header-component/>

                                    <div class="flex-1 flex items-start justify-center p-4 md:p-8">
                                        <div class="container mx-auto grid grid-cols-12 gap-20">
                                            <div class="col-span-3 w-full">
                                                <!-- Sidebar -->
                                                <livewire:account.components.sidebar/>
                                            </div>
                                            <div class="mx-auto space-y-6 col-span-9 w-full">
                                                <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg">
                                                    <div class="flex justify-between items-center mb-8">
                                                        <h1 class="text-2xl md:text-3xl font-bold">Detalles del Pedido</h1>
                                                        @php($orderColor = \Lunar\Admin\Support\OrderStatus::getColor($order->status))
                                                        <span class="px-3 py-1 rounded-full text-sm" style="background-color: rgb({{ $orderColor[500] }}); color: rgb({{ $orderColor[100] }})">
                                                            {{ \Lunar\Admin\Support\OrderStatus::getLabel($order->status) }}
                                                        </span>
                                                    </div>

                                                    <div class="border-t border-b border-gray-200 py-6 my-6">
                                                        <div class="flex flex-col md:flex-row justify-between gap-4">
                                                            <div class="grid grid-cols-2 gap-4 w-full md:w-2/3">
                                                                <div>
                                                                    <h3 class="text-sm font-semibold text-gray-500">Número de Orden</h3>
                                                                    <p class="font-medium">#{{ $order->id }}</p>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-sm font-semibold text-gray-500">Fecha</h3>
                                                                    <p class="font-medium">{{ $order->placed_at?->fromNow() ?? $order->created_at->fromNow() }}</p>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-sm font-semibold text-gray-500">Cliente</h3>
                                                                    <p class="font-medium">{{ $order->customer?->fullName ?? $order->billingAddress?->full_name ?? '---' }}</p>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-sm font-semibold text-gray-500">Email</h3>
                                                                    <p class="font-medium">{{ $order->customer?->email ?? $order->billingAddress?->contact_email ?? '---' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="w-full md:w-1/3">
                                                                <h3 class="text-sm font-semibold text-gray-500">Total</h3>
                                                                <p class="text-xl font-bold">{{ $order->total?->unitFormatted('es-cl') ?? '---' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-8">
                                                        <div>
                                                            <h3 class="font-semibold text-lg mb-4">Productos</h3>
                                                            <div class="overflow-x-auto">
                                                                <table class="w-full">
                                                                    <thead>
                                                                    <tr class="border-b border-gray-200">
                                                                        <th class="py-3 text-left text-sm font-semibold text-gray-500">Producto</th>
                                                                        <th class="py-3 text-center text-sm font-semibold text-gray-500">Cantidad</th>
                                                                        <th class="py-3 text-right text-sm font-semibold text-gray-500">Precio</th>
                                                                        <th class="py-3 text-right text-sm font-semibold text-gray-500">Total</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @if($order->lines->count() > 0)
                                                                        @foreach($order->lines as $line)
                                                                            <tr class="border-b border-gray-100">
                                                                                <td class="py-4">
                                                                                    <div class="flex items-center">
                                                                                        <span class="font-medium">{{ $line->description }}</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="py-4 text-center">{{ $line->quantity }}</td>
                                                                                <td class="py-4 text-right">{{ $line->unit_price->unitFormatted('es-cl') }}</td>
                                                                                <td class="py-4 text-right font-medium">{{ $line->total->unitFormatted('es-cl') }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="4" class="py-4 text-center text-gray-500">No se encontraron productos</td>
                                                                        </tr>
                                                                    @endif
                                                                    </tbody>
                                                                    <tfoot>
                                                                    <tr class="border-t border-gray-200">
                                                                        <td colspan="2" class="py-4 text-right font-medium">Subtotal:</td>
                                                                        <td colspan="2" class="py-4 text-right font-medium">{{ $order->sub_total?->unitFormatted('es-cl') ?? '---' }}</td>
                                                                    </tr>
                                                                    @if($order->discount_total?->value > 0)
                                                                    <tr>
                                                                        <td colspan="2" class="py-4 text-right font-medium">Descuento:</td>
                                                                        <td colspan="2" class="py-4 text-right font-medium text-red-600">-{{ $order->discount_total->unitFormatted('es-cl') }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if($order->shipping_total?->value > 0)
                                                                    <tr>
                                                                        <td colspan="2" class="py-4 text-right font-medium">Envío:</td>
                                                                        <td colspan="2" class="py-4 text-right font-medium">{{ $order->shipping_total->unitFormatted('es-cl') }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if($order->tax_total?->value > 0)
                                                                    <tr>
                                                                        <td colspan="2" class="py-4 text-right font-medium">Impuestos:</td>
                                                                        <td colspan="2" class="py-4 text-right font-medium">{{ $order->tax_total->unitFormatted('es-cl') }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    <tr class="border-t border-gray-200 font-bold">
                                                                        <td colspan="2" class="py-4 text-right">Total:</td>
                                                                        <td colspan="2" class="py-4 text-right text-xl">{{ $order->total?->unitFormatted('es-cl') ?? '---' }}</td>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                            <div>
                                                                <h3 class="font-semibold text-lg mb-4">Dirección de Envío</h3>
                                                                <div class="p-4 bg-gray-50 rounded-lg">
                                                                    @if($order->shippingAddress)
                                                                        <p class="font-bold">{{ $order->shippingAddress->full_name }}</p>
                                                                        <p class="text-gray-600">{{ $order->shippingAddress->line_one }}</p>
                                                                        <p class="text-gray-600">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postcode }}</p>
                                                                        <p class="text-gray-600">{{ $order->shippingAddress->contact_phone }}</p>
                                                                    @else
                                                                        <p class="text-gray-500">No se encontró información de envío.</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h3 class="font-semibold text-lg mb-4">Dirección de Facturación</h3>
                                                                <div class="p-4 bg-gray-50 rounded-lg">
                                                                    @if($order->billingAddress)
                                                                        <p class="font-bold">{{ $order->billingAddress->full_name }}</p>
                                                                        <p class="text-gray-600">{{ $order->billingAddress->line_one }}</p>
                                                                        <p class="text-gray-600">{{ $order->billingAddress->city }}, {{ $order->billingAddress->postcode }}</p>
                                                                        <p class="text-gray-600">{{ $order->billingAddress->contact_phone }}</p>
                                                                    @else
                                                                        <p class="text-gray-500">No se encontró información de facturación.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($order->notes || $order->shippingAddress?->delivery_instructions)
                                                        <div>
                                                            <h3 class="font-semibold text-lg mb-4">Notas</h3>
                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                <p class="text-gray-600">{{ $order->notes ?? $order->shippingAddress?->delivery_instructions ?? 'Sin notas adicionales.' }}</p>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($order->transactions->count() > 0)
                                                        <div>
                                                            <h3 class="font-semibold text-lg mb-4">Información de Pago</h3>
                                                            <div class="overflow-x-auto">
                                                                <table class="w-full">
                                                                    <thead>
                                                                    <tr class="border-b border-gray-200">
                                                                        <th class="py-3 text-left text-sm font-semibold text-gray-500">Método</th>
                                                                        <th class="py-3 text-right text-sm font-semibold text-gray-500">Cantidad</th>
                                                                        <th class="py-3 text-right text-sm font-semibold text-gray-500">Estado</th>
                                                                        <th class="py-3 text-right text-sm font-semibold text-gray-500">Fecha</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($order->transactions as $transaction)
                                                                        <tr class="border-b border-gray-100">
                                                                            <td class="py-4 capitalize">
                                                                                @if($transaction->card_type)
                                                                                    {{ $transaction->card_type }} **** {{ $transaction->last_four }}
                                                                                @else
                                                                                    {{ $transaction->driver }}
                                                                                @endif
                                                                            </td>
                                                                            <td class="py-4 text-right font-medium">{{ $transaction->amount->unitFormatted('es-cl') }}</td>
                                                                            <td class="py-4 text-right">
                                                                                <span class="px-2 py-1 rounded-full text-xs {{ $transaction->success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                                    {{ $transaction->status === 'paid' ? 'Pagado' : 'Desconocido' }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="py-4 text-right">{{ $transaction->created_at->fromNow() }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="mt-10 flex flex-col sm:flex-row justify-end gap-4">
                                                        <x-button link="{{ route('account.orders') }}" class="btn btn-outline" icon="o-arrow-left">
                                                            Volver a Mis Pedidos
                                                        </x-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <livewire:components.footer/>
                                </div>

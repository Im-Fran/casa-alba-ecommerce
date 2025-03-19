<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-start justify-center">
        <div class="container mx-auto grid grid-cols-12 gap-20">
            <div class="col-span-3 w-full">
                <!-- Sidebar -->
                <livewire:account.components.sidebar/>
            </div>
            <div class="mx-auto space-y-6 col-span-9 w-full">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold mb-6">Mis Pedidos</h2>

                    @if($orders->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-gray-400 mb-2">
                                <x-mary-icon name="o-shopping-bag" class="w-12 h-12 mx-auto" />
                            </div>
                            <p class="text-gray-500">No tienes pedidos realizados</p>
                            <x-button link="{{ route('home') }}" class="btn btn-outline btn-primary mt-4">
                                Explorar productos
                            </x-button>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-3 text-left text-sm font-semibold text-gray-500">Número</th>
                                    <th class="py-3 text-left text-sm font-semibold text-gray-500">Fecha</th>
                                    <th class="py-3 text-left text-sm font-semibold text-gray-500">Estado</th>
                                    <th class="py-3 text-right text-sm font-semibold text-gray-500">Total</th>
                                    <th class="py-3 text-right text-sm font-semibold text-gray-500">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-4 text-sm">#{{ $order->id }}</td>
                                        <td class="py-4 text-sm">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                        <td class="py-4 text-sm">
                                            @php($orderColor = \Lunar\Admin\Support\OrderStatus::getColor($order->status))
                                            <span class="px-2 py-1 rounded-full text-xs" style="background-color: rgb({{ $orderColor[500] }}); color: rgb({{ $orderColor[100] }})">{{ \Lunar\Admin\Support\OrderStatus::getLabel($order->status) }}</span>
                                        </td>
                                        <td class="py-4 text-sm text-right font-medium">{{ $order->total?->formatted() }}</td>
                                        <td class="py-4 text-right">
                                            <x-button link="{{ route('account.orders.view', $order->id) }}" size="sm" class="btn-ghost btn-sm">
                                                <x-mary-icon name="o-eye" class="w-4 h-4" />
                                                Ver
                                            </x-button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

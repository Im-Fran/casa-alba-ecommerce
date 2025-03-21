<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center p-4 md:p-8">
        <div class="container max-w-4xl mx-auto">
            <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg">
                <div class="flex flex-col items-center mb-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <x-heroicon-o-exclamation-triangle class="w-10 h-10 text-red-500"/>
                    </div>
                    <h1 class="text-3xl font-bold">Pago Cancelado</h1>
                    <p class="text-gray-600 mt-2">El proceso de pago ha sido cancelado. Puedes intentarlo nuevamente cuando estés listo.</p>
                </div>

                <div class="border-t border-b border-gray-200 py-6 my-6">
                    <div class="flex flex-col gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500">Número de Orden</h3>
                                <p class="font-medium">{{ $order->id ?? '---' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500">Fecha</h3>
                                <p class="font-medium">{{ now()->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500">Total</h3>
                            <p class="text-xl font-bold">{{ $order->total?->formatted() ?? '---' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <h3 class="font-semibold text-lg">Resumen del Pedido</h3>

                    <div class="space-y-4">
                        @if(isset($order->lines) && $order->lines->count() > 0)
                            @foreach($order->lines as $line)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $line->quantity }}x</span>
                                        <span class="ml-2">{{ $line->description }}</span>
                                    </div>
                                    <span class="font-medium">{{ $line->total->formatted() }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No se encontraron detalles del pedido.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <x-button link="{{ route('home') }}" class="btn btn-neutral" icon="o-home">
                        Volver a Inicio
                    </x-button>
                    <x-button wire:click="retry" class="btn btn-primary" icon="o-credit-card">
                        Reintentar Pago
                    </x-button>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

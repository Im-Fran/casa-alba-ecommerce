<div>
    <livewire:components.navigation.header-component/>

    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center h-[80vh]">
            <div class="w-full max-w-screen-md">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="flex flex-col items-center text-center">
                        @if ($status === 'success')
                            <div class="text-success mb-4">
                                <x-icon name="o-check-circle" class="w-16 h-16"/>
                            </div>
                            <h1 class="text-2xl font-bold">¡Correo Verificado!</h1>
                            <p class="text-gray-500 mt-2">Tu correo electrónico ha sido verificado correctamente.</p>
                        @elseif ($status === 'already_verified')
                            <div class="text-info mb-4">
                                <x-icon name="o-information-circle" class="w-16 h-16"/>
                            </div>
                            <h1 class="text-2xl font-bold">Correo ya Verificado</h1>
                            <p class="text-gray-500 mt-2">Tu correo electrónico ya está verificado.</p>
                        @elseif($status === 'invalid')
                            <div class="text-error mb-4">
                                <x-icon name="o-x-circle" class="w-16 h-16"/>
                            </div>
                            <h1 class="text-2xl font-bold">Error de Verificación</h1>
                            <p class="text-gray-500 mt-2">No se pudo verificar tu correo electrónico. El enlace puede haber expirado o ser inválido.</p>
                        @else
                            <div class="text-error mb-4">
                                <x-icon name="o-x-circle" class="w-16 h-16"/>
                            </div>
                            <h1 class="text-2xl font-bold">Error de Verificación</h1>
                            <p class="text-gray-500 mt-2">No se pudo verificar tu correo electrónico. El enlace puede haber expirado o ser inválido.</p>
                        @endif

                        <x-button link="{{ route('home') }}" class="btn btn-primary mt-6" wire:navigate>
                            Ir al Inicio
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

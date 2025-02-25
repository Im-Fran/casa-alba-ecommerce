<div>
    <livewire:components.navigation.header-component/>

    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center h-[80vh]">
            <div class="w-full max-w-screen-md">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-center">Creación de tu Cuenta</h1>
                        <p class="text-center text-gray-500 mt-2">Ingresa tus datos para crear tu cuenta</p>
                    </div>
                    <x-form class="mt-5" wire:submit.prevent="submit" action="dialog">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-input
                                label="Nombre"
                                type="text"
                                placeholder="Juan"
                                hint="Ingresa tu nombre"
                                autocomplete="given-name"
                                wire:model.blur="form.name"
                                first-error-only
                                required
                            />

                            <x-input
                                label="Apellido"
                                type="text"
                                placeholder="Perez"
                                hint="Ingresa tu apellido"
                                autocomplete="family-name"
                                wire:model.blur="form.last_name"
                                first-error-only
                                required
                            />
                        </div>

                        <x-input
                            label="Correo Electrónico"
                            type="email"
                            placeholder="juan.perez@ejemplo.cl"
                            hint="Ingresa tu correo electrónico"
                            autocomplete="email"
                            wire:model.blur="form.email"
                            first-error-only
                            required
                        />

                        <x-input
                            label="Contraseña"
                            type="password"
                            placeholder="********"
                            hint="Ingresa tu contraseña"
                            autocomplete="new-password"
                            wire:model.blur="form.password"
                            first-error-only
                            required
                        />

                        <x-input
                            label="Confirmar Contraseña"
                            type="password"
                            placeholder="********"
                            hint="Confirma tu contraseña"
                            autocomplete="new-password"
                            wire:model.blur="form.password_confirmation"
                            first-error-only
                            required
                        />

                        <div class="flex justify-between">
                            <a href="{{ route('login') }}" class="text-primary hover:underline">¿Ya tienes una cuenta?</a>
                            <x-button type="submit" class="btn btn-primary">Crear Cuenta</x-button>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

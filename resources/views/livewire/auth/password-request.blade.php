<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-screen-md bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-center">Restablecer Contraseña</h1>
                <p class="text-center text-gray-500 mt-2">Ingresa tu correo electrónico para recibir las instrucciones</p>
            </div>
            <x-form class="mt-5" wire:submit.prevent="submit" action="dialog">
                <x-input
                    label="Correo Electrónico"
                    type="email"
                    placeholder="juan.perez@ejemplo.cl"
                    hint="Ingresa el correo electrónico de tu cuenta"
                    autocomplete="email"
                    wire:model.blur="form.email"
                    first-error-only
                    required
                />

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-primary-content hover:underline">Volver al inicio de sesión</a>
                    <x-button type="submit" class="btn btn-primary">Enviar Instrucciones</x-button>
                </div>
            </x-form>
        </div>
    </div>

    <livewire:components.footer/>
</div>

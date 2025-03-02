<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-screen-md bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-center">Restablecer Contraseña</h1>
                <p class="text-center text-gray-500 mt-2">Ingresa tu nueva contraseña</p>
            </div>
            <x-form class="mt-5" wire:submit.prevent="submit">
                <x-input
                    label="Correo Electrónico"
                    type="email"
                    value="{{ $email }}"
                    autocomplete="email"
                    first-error-only
                    disabled
                />

                <x-input
                    label="Nueva Contraseña"
                    type="password"
                    placeholder="••••••••"
                    hint="Ingresa tu nueva contraseña"
                    autocomplete="new-password"
                    wire:model.blur="form.password"
                    first-error-only
                    required
                />

                <x-input
                    label="Confirmar Contraseña"
                    type="password"
                    placeholder="••••••••"
                    hint="Confirma tu nueva contraseña"
                    autocomplete="new-password"
                    wire:model.blur="form.password_confirmation"
                    first-error-only
                    required
                />

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-primary hover:underline">Volver al inicio de sesión</a>
                    <x-button type="submit" class="btn btn-primary">Restablecer Contraseña</x-button>
                </div>
            </x-form>
        </div>
    </div>

    <livewire:components.footer/>
</div>

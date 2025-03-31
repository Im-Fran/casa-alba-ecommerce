<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-screen-md bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-center">Iniciar Sesión</h1>
                <p class="text-center text-gray-500 mt-2">Ingresa tus credenciales para acceder</p>
            </div>
            <x-form class="mt-5" wire:submit.prevent="submit">
                <x-input
                    label="Correo Electrónico"
                    type="email"
                    placeholder="juan.perez@ejemplo.cl"
                    hint="Ingresa tu correo electrónico"
                    autocomplete="email"
                    wire:model.blur="form.email"
                    autofocus
                    first-error-only
                    required
                />

                <x-input
                    label="Contraseña"
                    type="password"
                    placeholder="********"
                    hint="Ingresa tu contraseña"
                    autocomplete="current-password"
                    wire:model.blur="form.password"
                    first-error-only
                    required
                />

                <x-checkbox
                    label="Recuérdame"
                    wire:model="form.remember"
                    first-error-only
                />

{{--                <livewire:components.turnstile--}}
{{--                    wire:model="form.cfTurnstileResponse"--}}
{{--                />--}}


                <div class="flex items-center justify-between">
                    <div class="space-x-4">
                        <a href="{{ route('password.request') }}" class="text-primary-content hover:underline">¿Olvidaste tu contraseña?</a>
                        <a href="{{ route('register') }}" class="text-primary-content hover:underline">¿No tienes cuenta?</a>
                    </div>
                    <x-button type="submit" class="btn btn-primary">Iniciar Sesión</x-button>
                </div>
            </x-form>
        </div>
    </div>

    <livewire:components.footer/>
</div>

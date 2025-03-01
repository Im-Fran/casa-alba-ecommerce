<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center">
        <x-form class="w-full lg:w-1/2 bg-white border border-neutral-300 p-8 rounded-2xl shadow-lg space-y-4" wire:submit.prevent="submit">
            <div class="flex flex-col items-start">
                <h1 class="text-2xl font-bold text-center">Creación de tu Cuenta</h1>
                <p class="text-center text-gray-500 mt-2">Ingresa tus datos para crear tu cuenta</p>
            </div>

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


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <x-input
                    icon="o-phone"
                    label="Número de Teléfono"
                    placeholder="+56 9 1234 5678"
                    autocomplete="tel"
                    type="tel"
                    inputmode="tel"
                    x-mask="+99 9 9999 9999"
                    wire:model.live.debounce="form.phone"
                    required
                    first-error-only
                />

                <x-input
                    icon="o-identification"
                    label="RUT"
                    placeholder="99.999.999-9"
                    x-mask:dynamic="$input.length < 12 ? '9.999.999-99' : '99.999.999-9'"
                    hint="Si tu RUT termina en K, reemplázalo por un 0"
                    inputmode="tel"
                    wire:model.live.debounce="form.rut"
                    required
                    first-error-only
                />
            </div>

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

    <livewire:components.footer/>
</div>

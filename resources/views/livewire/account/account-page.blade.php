<div>
    <livewire:components.navigation.header-component/>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-screen-md mx-auto space-y-6">
            <h1 class="text-2xl font-bold">Configuración de la Cuenta</h1>

            <!-- Personal Information -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
                <x-form wire:submit.prevent="updateProfile">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-input
                            label="Nombre"
                            wire:model="form.name"
                            type="text"
                            required
                            first-error-only
                        />
                        <x-input
                            label="Apellido"
                            wire:model="form.last_name"
                            type="text"
                            required
                            first-error-only
                        />
                    </div>
                    <x-input
                        label="Correo Electrónico"
                        wire:model="form.email"
                        type="email"
                        required
                        first-error-only
                    />
                    <div class="flex justify-end">
                        <x-button type="submit" class="btn btn-primary" spinner>
                            Guardar Cambios
                        </x-button>
                    </div>
                </x-form>
            </div>

            <!-- Password Change -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Cambiar Contraseña</h2>
                <x-form wire:submit.prevent="updatePassword">
                    <x-input
                        label="Contraseña Actual"
                        wire:model="form.current_password"
                        type="password"
                        required
                        first-error-only
                    />
                    <x-input
                        label="Nueva Contraseña"
                        wire:model="form.new_password"
                        type="password"
                        required
                        first-error-only
                    />
                    <x-input
                        label="Confirmar Nueva Contraseña"
                        wire:model="form.new_password_confirmation"
                        type="password"
                        required
                        first-error-only
                    />
                    <div class="flex justify-end">
                        <x-button type="submit" class="btn btn-primary" spinner>
                            Actualizar Contraseña
                        </x-button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

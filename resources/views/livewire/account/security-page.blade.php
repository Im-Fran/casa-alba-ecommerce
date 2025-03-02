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
                    <h2 class="text-xl font-semibold mb-8">Seguridad de la Cuenta</h2>
                    <x-form class="space-y-4" wire:submit.prevent="submit">
                        <x-input
                            label="Contraseña actual"
                            wire:model="form.current_password"
                            type="password"
                            placeholder="••••••••"
                            required
                            first-error-only
                        />

                        <x-input
                            label="Nueva contraseña"
                            wire:model="form.new_password"
                            type="password"
                            hint="Mínimo 8 caracteres"
                            placeholder="••••••••"
                            required
                            first-error-only
                        />

                        <x-input
                            label="Confirmar nueva contraseña"
                            wire:model="form.new_password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            required
                            first-error-only
                        />

                        <div class="flex justify-end">
                            <x-button type="submit" class="btn btn-primary" spinner>
                                Cambiar Contraseña
                            </x-button>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

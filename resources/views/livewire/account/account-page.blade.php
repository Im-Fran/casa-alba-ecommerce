<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-start justify-center">
        <div class="container mx-auto grid grid-cols-12 gap-20">
            <div class="col-span-3 w-full">
                <!-- Sidebar -->
                <div class="bg-white p-4 rounded-lg shadow-lg top-20 w-full">
                    <h2 class="text-xl font-semibold mb-4 text-primary">Mi Cuenta</h2>

                    <div class="space-y-2 w-full">
                        <a href="{{ route('account') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-100 transition-colors" wire:current="text-primary" wire:navigate.hover>
                            <x-icon name="o-user" class="w-5 h-5" />
                            <span>Información de la Cuenta</span>
                        </a>

                        <a href="{{ route('account') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-100 transition-colors" wire:current="text-primary" wire:navigate.hover>
                            <x-icon name="o-lock-closed" class="w-5 h-5" />
                            <span>Seguridad</span>
                        </a>

                        <a href="{{ route('account') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-100 transition-colors" wire:current="text-primary" wire:navigate.hover>
                            <x-icon name="o-map-pin" class="w-5 h-5" />
                            <span>Direcciones</span>
                        </a>

                        <a href="{{ route('account') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-100 transition-colors" wire:current="text-primary" wire:navigate.hover>
                            <x-icon name="o-shopping-cart" class="w-5 h-5" />
                            <span>Ordenes</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mx-auto space-y-6 col-span-9 w-full">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold mb-8">Información de la Cuenta</h2>
                    <x-form class="space-y-4" wire:submit.prevent="submit">
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

                        <div class="flex justify-end">
                            <x-button type="submit" class="btn btn-primary" spinner>
                                Guardar Cambios
                            </x-button>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

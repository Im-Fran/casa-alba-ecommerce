<div class="flex items-center">
    @auth
        <x-dropdown>
            <x-menu-title title="Mi Cuenta"/>
            <x-menu-item title="Información de la Cuenta" icon="o-identification" link="{{ route('account') }}" wire:current="text-primary"/>
            <x-menu-item title="Seguridad" icon="o-lock-closed" link="{{ route('account') }}" wire:current="text-primary"/>
            <x-menu-item title="Direcciones" icon="o-map-pin" link="{{ route('account') }}" wire:current="text-primary"/>
            <x-menu-item title="Ordenes" icon="o-shopping-cart" link="{{ route('account') }}" wire:current="text-primary"/>

            <x-menu-separator/>
            <x-menu-item title="Cerrar Sesión" icon="o-arrow-left-on-rectangle" link="{{ route('logout') }}"/>

            <x-slot:trigger>
                <x-lucide-user class="w-6 h-6 md:w-8 md:h-8 cursor-pointer text-neutral-100"/>
            </x-slot:trigger>
        </x-dropdown>
    @else
        <x-lucide-user wire:click="clickAuthModal" class="w-6 h-6 md:w-8 md:h-8 cursor-pointer text-neutral-100"/>
    @endauth

    <x-modal wire:model="open" title="Ingresar a la Tienda" subtitle="Ingresa tu correo para iniciar sesión o registrarte">
        <x-form wire:submit.prevent="submit">
            <x-input
                type="email"
                label="Correo"
                placeholder="juan.perez@ejemplo.cl"
                wire:model.blur="email"
                required
                first-error-only
            />
            <x-button class="btn btn-primary" type="submit">Enviar</x-button>
        </x-form>
    </x-modal>
</div>

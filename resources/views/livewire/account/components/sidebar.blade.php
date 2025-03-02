<div class="bg-white p-4 rounded-lg shadow-lg top-20 w-full">
    <h2 class="text-xl font-semibold mb-4 text-primary">Mi Cuenta</h2>

    <div class="space-y-2 w-full">
        <a href="{{ route('account') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-100 transition-colors" wire:current="text-primary" wire:navigate.hover>
            <x-icon name="o-identification" class="w-5 h-5" />
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

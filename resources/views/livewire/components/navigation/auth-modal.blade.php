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

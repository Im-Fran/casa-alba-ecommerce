<div class="flex flex-col items-center justify-center py-20 w-full">
    <h1 class="text-4xl max-w-2xl font-bold text-center mb-10">Contactanos</h1>

    <x-form class="w-full lg:w-1/2 bg-white p-8 rounded-2xl shadow-lg space-y-4" wire:submit.prevent="submit">
        <x-input
            class="rounded-lg"
            id="name"
            label="Nombre"
            type="text"
            wire:model.blur="form.name"
            autocomplete="name"
            placeholder="Tu Nombre"
            first-error-only
            autofocus
        />

        <x-input
            class="rounded-lg"
            id="email"
            label="Correo Electrónico"
            type="email"
            wire:model.blur="form.email"
            autocomplete="email"
            placeholder="Tu Correo Electrónico"
            first-error-only
        />

        <x-textarea
            class="rounded-lg"
            id="message"
            label="Mensaje"
            wire:model.blur="form.message"
            placeholder="Tu Mensaje"
            first-error-only
        />

        <x-slot:actions>
            <x-button label="Enviar" type="submit" class="btn-primary"/>
        </x-slot:actions>
    </x-form>
</div>

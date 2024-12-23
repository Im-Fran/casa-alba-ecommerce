<div class="flex flex-col items-center justify-center py-20 w-full">
    <h1 class="text-4xl max-w-2xl font-bold text-center mb-10">Contactanos</h1>

    <form class="w-full lg:w-1/2 bg-white p-8 rounded-2xl shadow-lg" wire:submit.prevent="submit">
        <div class="mb-4">
            <x-label for="name">Nombre</x-label>
            <x-input
                id="name"
                type="text"
                error-field="name"
                wire:model="name"
                placeholder="Tu Nombre"
                autocomplete="name"
                autofocus
            />
        </div>

        <div class="mb-4">
            <x-label for="email">Correo Electrónico</x-label>
            <x-input
                id="email"
                type="email"
                error-field="email"
                wire:model="email"
                placeholder="Tu Correo Electrónico"
                autocomplete="email"
            />
        </div>

        <div class="mb-4">
            <x-label for="message">Mensaje</x-label>
            <x-textarea
                id="message"
                error-field="message"
                wire:model="message"
                placeholder="Tu Mensaje"
            />
        </div>

        <div class="flex items-center justify-between">
            <x-button label="Enviar" type="submit" class="btn-primary"/>
        </div>
    </form>
</div>

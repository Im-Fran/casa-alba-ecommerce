<div>
    <livewire:components.navigation.header-component/>

    <div class="flex flex-col items-center justify-center min-h-screen w-full h-full p-2">
        <div class="flex flex-grow flex-col items-center justify-center w-full min-h-full">
            <div class="hidden md:flex flex-col mb-10">
                <h1 class="text-4xl max-w-2xl font-bold text-center">Contactanos</h1>
                <span class="text-lg max-w-2xl text-center mb-10">¿Tienes alguna duda o sugerencia? ¡Escríbenos!</span>
            </div>

            <x-form class="w-full lg:w-1/2 bg-white border border-neutral-300 p-8 rounded-2xl shadow-lg space-y-4" wire:submit.prevent="submit">
                <div class="flex flex-col items-start md:hidden">
                    <h1 class="text-2xl max-w-2xl font-bold">Contactanos</h1>
                    <span class="text-sm max-w-xl">¿Tienes alguna duda o sugerencia? ¡Escríbenos!</span>
                </div>

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
                    <x-button label="Enviar" type="submit" class="btn-primary" icon-right="o-paper-airplane" spinner="submit"/>
                </x-slot:actions>
            </x-form>
        </div>
    </div>

    <livewire:components.footer/>
</div>

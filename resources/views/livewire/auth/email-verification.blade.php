<div class="min-h-screen flex flex-col">
    <livewire:components.navigation.header-component/>

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-screen-md bg-white p-8 rounded-lg shadow-lg flex flex-col items-center text-center">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-center">Verificación de Correo Electrónico</h1>
                <p class="text-center text-gray-500 mt-2">Para continuar, necesitamos verificar tu correo electrónico</p>
            </div>

            <div class="mt-5">
                <p class="text-center mb-6">
                    Si no has recibido el correo de verificación, puedes solicitar uno nuevo haciendo clic en el botón de abajo.
                    <br>
                    <span class="text-sm text-gray-500">Recuerda revisar tu carpeta de spam.</span>
                </p>

                <div class="flex items-center justify-center gap-5">
                    <x-button link="{{ route('logout') }}" class="btn text-red-50 btn-error" icon-right="o-arrow-left-on-rectangle" wire:navigate>Cerrar Sesión</x-button>
                    <x-button wire:click="submit" class="btn btn-primary" icon-right="o-paper-airplane" spinner>Reenviar Correo de Verificación</x-button>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.footer/>
</div>

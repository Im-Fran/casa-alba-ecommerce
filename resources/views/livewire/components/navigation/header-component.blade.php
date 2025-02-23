<div x-data="{ sticky: $wire.entangle('sticky') }" x-bind:class="(sticky ? 'sticky' : 'relative') + ' top-0 z-10'">
    <div class="absolute inset-x-0 mt-10 mx-5">
        <div class="bg-primary p-2 px-5 rounded-[2rem]">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="hover:text-secondary text-2xl font-medium" wire:navigate>
                    <img src="{{ asset('images/casaalba.webp') }}" alt="CasaAlba" class="rounded-full w-16"/>
                </a>

                <ul class="hidden md:flex items-center space-x-4 text-neutral-100">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-secondary text-2xl font-medium" wire:navigate>Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-secondary text-2xl font-medium" wire:navigate.hover>Contacto</a>
                    </li>
                </ul>

                <div class="flex items-center space-x-4">
                    <livewire:components.navigation.cart-component/>

                    <x-lucide-menu wire:click.stop="$toggle('openMobileNav')" class="text-neutral-100 hover:text-secondary w-8 h-8 cursor-pointer block md:hidden"/>

                    <x-drawer title="Casa Alba" wire:model="openMobileNav" class="w-11/12 lg:w-1/3" right withCloseButton>
                        <ul class="flex flex-col space-y-4">
                            <li>
                                <a href="{{ route('home') }}" class="hover:text-primary" wire:navigate>Inicio</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="hover:text-primary" wire:navigate.hover>Contacto</a>
                            </li>
                        </ul>
                    </x-drawer>
                </div>
            </div>
        </div>
    </div>
</div>

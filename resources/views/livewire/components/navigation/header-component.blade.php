<header class="sticky top-0 bg-gradient-to-b from-primary to-transparent backdrop-blur z-[9999] pb-5">
    <nav class="container mx-auto px-5 md:px-0 pt-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="hidden md:flex items-center justify-center">
            <img
                src="{{ asset('images/casaalba.png') }}"
                alt="Casa Alba"
                class="h-20 rounded-full"
            />
        </a>

        <x-drawer title="Casa Alba" wire:model="openMobileNav" class="w-11/12 lg:w-1/3" withCloseButton>
            <ul class="flex flex-col space-y-4">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="hover:text-primary">Contacto</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary">Nosotros</a>
                </li>
            </ul>
        </x-drawer>
        <img
            wire:click="$toggle('openMobileNav')"
            src="{{ asset('images/casaalba.png') }}"
            alt="Casa Alba"
            class="md:hidden h-20 rounded-full"
        />

        <ul class="hidden md:flex items-center space-x-4">
            <li>
                <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="hover:text-primary">Contacto</a>
            </li>
            <li>
                <a href="#" class="hover:text-primary">Nosotros</a>
            </li>
        </ul>


        <div class="flex items-center space-x-4">
            <a href="#">
                <x-lucide-search class="hover:text-primary w-6 h-6"/>
            </a>
            <livewire:components.cart-component/>
        </div>
    </nav>
</header>

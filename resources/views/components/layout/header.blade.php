<header class="sticky top-0 bg-gradient-to-b from-primary to-transparent backdrop-blur z-[9999] pb-5">
    <nav class="container mx-auto pt-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center justify-center">
            <img
                src="{{ asset('images/casaalba.png') }}"
                alt="Casa Alba"
                class="h-20 rounded-full"
            />
        </a>

        <ul class="flex items-center space-x-4">
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

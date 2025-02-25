<div x-data="{ sticky: $wire.entangle('sticky'), mobileNavOpen: false, closeMobileNav(){ this.mobileNavOpen=false;$refs.checkbox.checked=false; } }" x-bind:class="(sticky ? 'sticky' : ('relative')) + ' top-0 z-10 pb-[8rem]'">
    <div class="absolute inset-x-0 mx-0 md:mx-5 z-50">
        <div class="bg-primary transition-all duration-[.75s]" x-bind:class="{'px-2 py-5 rounded-none': mobileNavOpen, 'mx-2 mt-5 rounded-[1rem]': !mobileNavOpen}">
            <div class="flex items-center justify-between p-2">
                <a href="{{ route('home') }}" wire:navigate>
                    <img src="{{ asset('images/casaalba.webp') }}" alt="CasaAlba" class="rounded-full h-10 md:h-12"/>
                </a>

                <ul class="hidden md:flex items-center space-x-4 text-neutral-100">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-secondary text-2xl font-medium relative w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-secondary after:w-full after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-right" wire:current.exact="after:scale-x-100" wire:navigate>Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-secondary text-2xl font-medium relative w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-secondary after:w-full after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-right" wire:current.exact="after:scale-x-100" wire:navigate.hover>Contacto</a>
                    </li>
                </ul>

                <div class="flex items-center space-x-4">
                    <x-lucide-user wire:click="clickAuthModal" class="w-6 h-6 md:w-8 md:h-8 cursor-pointer text-neutral-100"/>

                    <livewire:components.navigation.cart-component/>

                    <div class="block md:hidden">
                        <x-lucide-menu x-show="!mobileNavOpen" @click="mobileNavOpen = !mobileNavOpen" class="text-neutral-100 w-6 h-6 cursor-pointer"/>
                        <x-lucide-x x-show="mobileNavOpen" @click="mobileNavOpen = !mobileNavOpen" class="text-neutral-100 w-6 h-6 cursor-pointer"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.navigation.auth-modal wire:model="authModal"/>

    <div class="drawer absolute z-40 drawer-end" x-trap="mobileNavOpen" x-bind:insert="!mobileNavOpen">
        <input id="mobile-nav-drawer" type="checkbox" class="drawer-toggle" x-ref="checkbox" x-model="mobileNavOpen" />
        <div class="drawer-side">
            <label for="mobile-nav-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <x-mary-card wire:key="mobile-nav-card" class="w-full h-screen rounded-none bg-primary">
                <div class="h-[90vh]">
                    <ul class="flex flex-col space-y-4 mt-20 h-[60vh]">
                        <li>
                            <a href="{{ route('home') }}" class="flex items-center justify-start gap-2 text-xl text-primary-content hover:text-secondary" wire:navigate><x-lucide-home class="w-6 h-6"/> Inicio</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="flex items-center justify-start gap-2 text-xl text-primary-content hover:text-secondary" wire:navigate.hover><x-lucide-contact class="w-6 h-6"/> Contacto</a>
                        </li>
                    </ul>

                    <div class="bg-primary flex items-start justify-start mt-16">
                        <a class="flex items-center gap-1 text-lg text-secondary" href="https://instagram.com/productoscasaalba/" target="_blank"><x-lucide-instagram class="w-5 h-5"/> productoscasaalba</a>
                    </div>
                </div>
            </x-mary-card>
        </div>
    </div>
</div>

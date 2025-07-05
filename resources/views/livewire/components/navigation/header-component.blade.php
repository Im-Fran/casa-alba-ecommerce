<div x-data="{ sticky: $wire.entangle('sticky'), mobileNavOpen: false, closeMobileNav(){ this.mobileNavOpen=false;$refs.checkbox.checked=false; } }" x-bind:class="(sticky ? 'sticky' : ('relative')) + ' top-0 z-10 pb-[8rem]'">
    @php($links =[
        ['title' => 'Inicio', 'url' => route('home'), 'icon' => 'o-home'],
        ['title' => 'Contacto', 'url' => route('contact'), 'icon' => 'o-device-phone-mobile'],
    ])
    <div class="absolute inset-x-0 mx-0 md:mx-5 z-50">
        <div class="bg-primary transition-all duration-[.75s]" x-bind:class="{'px-2 py-5 rounded-none': mobileNavOpen, 'mx-2 mt-5 rounded-[1rem]': !mobileNavOpen}">
            <div class="flex items-center justify-between p-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/casaalba-t.png') }}" alt="CasaAlba" class="rounded-full h-10 md:h-12"/>
                </a>

                <ul class="hidden md:flex items-center space-x-4 text-primary-content">
                    @foreach($links as $link)
                        <li wire:key="nav_link_{{$loop->index}}">
                            <a href="{{$link['url']}}" class="hover:text-primary-content/80 text-2xl font-medium relative w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-primary-content after:w-full after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-right" wire:current.exact="after:scale-x-100">{{$link['title']}}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="flex items-center space-x-4">
                    @env(['local'])
                        <a target="_blank" href="{{ Str::replaceLast('/', '', url(':8025')) }}" class="text-primary-content text-sm font-medium hover:text-primary-content/80"><x-lucide-mail class="w-6 h-6 md:w-8 md:h-8"/></a>
                    @endenv

                    <livewire:components.navigation.auth-modal wire:model="authModal"/>

                    <livewire:components.navigation.cart-component/>

                    <div class="block md:hidden">
                        <x-lucide-menu x-show="!mobileNavOpen" @click="mobileNavOpen = !mobileNavOpen" class="text-primary-content w-6 h-6 cursor-pointer"/>
                        <x-lucide-x x-show="mobileNavOpen" @click="mobileNavOpen = !mobileNavOpen" class="text-primary-content w-6 h-6 cursor-pointer"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div class="drawer absolute z-40 drawer-end" x-trap="mobileNavOpen" x-bind:insert="!mobileNavOpen">
        <input id="mobile-nav-drawer" type="checkbox" class="drawer-toggle" x-ref="checkbox" x-model="mobileNavOpen" />
        <div class="drawer-side">
            <label for="mobile-nav-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div wire:key="mobile-nav-card" class="w-full h-full rounded-none bg-primary card p-5">
                <div class="flex-1 flex flex-col justify-between w-full">
                    <ul class="flex flex-col space-y-4 mt-20">
                        @foreach($links as $link)
                            <li>
                                <a href="{{ $link['url'] }}" class="flex items-center justify-start gap-2 text-xl text-primary-content hover:text-primary-content/80"><x-icon name="{{ $link['icon'] }}" class="w-6 h-6"/> {{ $link['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="bg-primary flex items-center justify-end mt-16 bottom-0 right-0 w-full">
                        <a class="flex items-center gap-1 text-lg text-neutral-50" href="https://instagram.com/productoscasaalba/" target="_blank"><x-lucide-instagram class="w-10 h-10"/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

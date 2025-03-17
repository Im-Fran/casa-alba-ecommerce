<div class="text-neutral-900" x-on:open-cart.window="$set('openCart', true)">
    <x-drawer title="Carrito de Compras" wire:model="openCart" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[90vh]" x-on:cart-updated.window="$wire.$refresh()">
            <livewire:components.cart.product-list wire:key="cart-product-list" wire:model="cart"/>
            <livewire:components.cart.prices-detail wire:key="cart-prices-detail" wire:model="cart"/>
        </div>
    </x-drawer>

    <x-lucide-shopping-bag x-on:click.stop="closeMobileNav" wire:click.stop="$toggle('openCart')" class="text-primary-content hover:text-primary-content/80 w-6 h-6 md:w-8 md:h-8 cursor-pointer"/>
</div>

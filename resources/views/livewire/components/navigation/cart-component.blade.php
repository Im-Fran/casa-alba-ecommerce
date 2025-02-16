<div class="text-neutral-900">
    <x-drawer title="Carrito de Compras" wire:model="openCart" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[90vh]">
            <livewire:components.cart.product-list wire:key="cart-product-list" wire:model="cart"/>
            <livewire:components.cart.prices-detail wire:key="cart-prices-detail" wire:model="cart"/>
        </div>

        @script
        <script>Livewire.on('cart-updated', () => $wire.$refresh())</script>
        @endscript
    </x-drawer>

    <x-lucide-shopping-bag wire:click.stop="$toggle('openCart')" class="text-neutral-100 hover:text-secondary w-8 h-8 cursor-pointer"/>
</div>

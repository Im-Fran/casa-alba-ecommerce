<div>
    <x-drawer title="Carrito de Compras" wire:model="openCart" class="w-11/12 lg:w-1/3" right withCloseButton>
        <div class="flex flex-col items-stretch justify-between w-full h-[90vh]">
            <livewire:components.cart.product-list/>
            <livewire:components.cart.prices-detail/>
        </div>
    </x-drawer>

    <x-lucide-shopping-bag wire:click.stop="$toggle('openCart')" class="hover:text-primary w-8 h-8 cursor-pointer"/>
</div>

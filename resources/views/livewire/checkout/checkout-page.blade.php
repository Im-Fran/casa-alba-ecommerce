<div>
    <livewire:components.navigation.header-component :sticky="false"/>

    <div class="h-full w-full min-h-screen pt-[10rem]">
        <div class="grid grid-cols-10 gap-10">
            <div class="col-span-4">
                <livewire:checkout.components.product-list
                    wire:model="cart"
                />
            </div>
            <div class="col-span-6">

            </div>
        </div>
    </div>
</div>

<div id="banner" class="grid grid-cols-1 md:grid-cols-2 items-center justify-center pb-20 pt-[10rem] w-full">
    <div class="absolute md:static col-span-1 flex flex-col items-center justify-center gap-5 z-[2] mt-[10rem] md:mt-0 inset-x-0">
        <h1 class="text-2xl md:text-8xl max-w-2xl font-bold text-center">Productos de Aseo para tu Hogar</h1>

        <x-button
            class="btn btn-primary btn-sm md:btn-lg"
            label="Comprar Ahora"
            icon-right="o-arrow-down"
            wire:click="navigateToProductos"
        />
    </div>

    <img
        src="{{ asset('/images/productos_limpieza.webp') }}"
        alt="Productos de Limpieza"
        class="col-span-1 object-cover object-center w-full rounded-2xl blur-[5px] md:blur-0 z-[1]"
    />
</div>

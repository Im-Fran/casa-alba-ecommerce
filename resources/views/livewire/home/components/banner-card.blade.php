<div class="grid grid-cols-2 items-center justify-center py-20 w-full">
    <div class="col-span-1 flex flex-col items-center justify-center gap-5">
        <h1 class="text-6xl md:text-8xl max-w-2xl font-bold text-center">Productos de Aseo para tu Hogar</h1>

        <x-button
            class="btn btn-primary btn-lg"
            label="Comprar Ahora"
            icon-right="o-arrow-down"
            x-on:click="navigateToProductos()"
        />
    </div>

    <img
        src="{{ asset('/images/productos_limpieza.webp') }}"
        alt="Productos de Limpieza"
        class="col-span-1 object-cover object-top w-full rounded-2xl"
    />

    @script
    <script>
        const navigateToProductos = () => {
            document.querySelector('#productos').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    @endscript
</div>

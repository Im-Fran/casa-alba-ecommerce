<section id="banner" class="relative pb-20 pt-0 md:pt-[10rem] bg-gradient-to-r from-primary/10 to-secondary/10 min-h-screen flex items-center">
    <div class="grid grid-cols-1 md:grid-cols-2 items-center justify-center w-full">
        <div class="absolute md:static col-span-1 flex flex-col items-center justify-center gap-5 z-[2] mt-[10rem] md:mt-0 inset-x-0">
            <h1 class="text-2xl md:text-8xl max-w-2xl text-center">Productos de Aseo para tu Hogar</h1>

            <x-button
                class="btn btn-primary btn-sm md:btn-lg font-extralight"
                label="Comprar Ahora"
                icon-right="o-arrow-down"
                x-on:click="window.scrollTo({ top: document.getElementById('banner').scrollHeight * 0.85, behavior: 'smooth' })"
            />
        </div>

        <img
            src="{{ asset('/images/productos_limpieza.webp') }}"
            alt="Productos de Limpieza"
            class="col-span-1 object-cover object-center w-full rounded-l-2xl blur-[10px] md:blur-0 z-[1]"
        />
    </div>
</section>

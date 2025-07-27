<footer class="mt-auto p-2 md:p-0">
    <div class="container mx-auto py-8 mt-2.5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="col-span-1">
                <h3 class="text-lg font-medium text-primary-content mb-2.5">Casa Alba</h3>
                <p class="text-neutral-700">Venta online de productos para el hogar, limpieza y aseo. Somos una marca propia con artículos de excelente calidad.</p>
            </div>
            <div class="col-span-1 md:col-start-3">
                <h3 class="text-lg font-medium text-neutral-900 mb-2.5">Redes Sociales</h3>
                <div class="space-y-1">
                    <a href="{{ route('redirect.whatsapp') }}" target="_blank" class="flex items-center justify-start text-neutral-700 hover:text-primary-content transition duration-300 gap-1 font-sans">
                        <img src="{{ asset('images/logos/whatsapp-icon-black.svg') }}" alt="WhatsApp Icon" class="w-6 h-6"/> +56 9 4271 7395
                    </a>
                    <a href="{{ route('redirect.instagram') }}" target="_blank" class="flex items-center justify-start text-neutral-700 hover:text-primary-content transition duration-300 gap-1 font-sans"><x-lucide-instagram class="w-6 h-6"/> productoscasaalba</a>
                    <a href="{{ route('redirect.tiktok') }}" target="_blank" class="flex items-center justify-start text-neutral-700 hover:text-primary-content transition duration-300 gap-1 font-sans"><img src="{{ asset('images/tiktok.webp') }}" alt="TikTok Icon" class="w-6 h-6"/> productoscasaalba</a>
                </div>
            </div>
        </div>
    </div>
</footer>

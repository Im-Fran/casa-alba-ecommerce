<section id="banner" class="pb-20 pt-0 md:pt-[10rem] bg-gradient-to-r from-primary/10 to-secondary/10 min-h-screen flex items-center">
    <div class="container mx-auto flex flex-col items-center justify-center text-center space-y-8">
        <!-- Company Logo -->
        <div class="flex justify-center">
            <div class="w-48 h-48 md:w-60 md:h-60 rounded-full flex items-center justify-center">
                <img src="{{ asset('images/casaalba-t.png') }}" alt="Casa Alba Logo" class="w-full h-full object-contain rounded-full">
            </div>
        </div>

        <!-- Company Name -->
        <h1 class="text-3xl md:text-6xl font-light text-primary-content mb-4">
            Productos Casa Alba
        </h1>

        <!-- Contact Information -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12">
            <!-- WhatsApp Contact -->
            <a
                href="{{ route('redirect.whatsapp') }}"
                target="_blank"
                class="flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full transition-colors duration-300 shadow-lg hover:shadow-xl"
            >
                <img
                    src="{{ asset('images/logos/whatsapp-icon-white.svg') }}"
                    alt="WhatsApp Glyph Icon"
                    class="w-5 h-5"
                />
                <span class="font-sans">+56 9 4271 7395</span>
            </a>
        </div>

        <!-- Social Media Links -->
        <div class="flex items-center justify-center gap-6">
            <span class="text-lg text-primary-content">Síguenos:</span>

            <!-- Instagram -->
            <a
                href="https://instagram.com/productoscasaalba"
                target="_blank"
                class="flex items-center gap-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-md hover:shadow-lg"
            >
                <img alt="TikTok Logo" src="{{ asset('/images/logos/instagram/instagram-white.svg') }}" class="h-6 w-6"/>
                <span class="font-sans">@productoscasaalba</span>
            </a>

            <!-- TikTok -->
            <a
                href="https://tiktok.com/@productoscasaalba"
                target="_blank"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-md hover:shadow-lg"
            >
                <img alt="TikTok Logo" src="{{ asset('/images/logos/tiktok/tiktok.webp') }}" class="h-6 w-6"/>
                <span class="font-sans">@productoscasaalba</span>
            </a>
        </div>
    </div>
</section>

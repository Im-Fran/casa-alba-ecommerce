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
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                <span class="font-sans">@productoscasaalba</span>
            </a>

            <!-- TikTok -->
            <a
                href="https://tiktok.com/@productoscasaalba"
                target="_blank"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-md hover:shadow-lg"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.39v13.46a2.93 2.93 0 0 1-5.86 0 2.93 2.93 0 0 1 2.93-2.93c.3 0 .58.05.86.13V9.24a6.33 6.33 0 0 0-.86-.05A6.33 6.33 0 0 0 3.17 15.52a6.33 6.33 0 0 0 6.33 6.33A6.33 6.33 0 0 0 15.83 15.52V9.57a8.16 8.16 0 0 0 4.76 1.54v-3.4a4.85 4.85 0 0 1-1-.02z"/>
                </svg>
                <span class="font-sans">@productoscasaalba</span>
            </a>
        </div>
    </div>
</section>

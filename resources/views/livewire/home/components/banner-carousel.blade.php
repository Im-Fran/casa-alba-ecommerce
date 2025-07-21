<div x-data="{
    active: 0,
    count: 2,
    autoplay: true,
    interval: null,
    init() {
        this.startAutoplay();
    },
    startAutoplay() {
        if (this.autoplay) {
            this.interval = setInterval(() => {
                this.next();
            }, 7000); // Change slide every 5 seconds
        }
    },
    stopAutoplay() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    },
    next() {
        this.active = (this.active + 1) % this.count;
    },
    prev() {
        this.active = (this.active - 1 + this.count) % this.count;
    },
    goTo(index) {
        this.active = index;
    }
}"
@mouseenter="stopAutoplay()"
@mouseleave="startAutoplay()"
class="relative w-full overflow-hidden">

    <!-- Slides container -->
    <div class="flex transition-transform duration-700 ease-in-out" :style="`transform: translateX(-${active * 100}%)`">
        <div class="w-full flex-shrink-0">
            <livewire:home.components.banner-company-info/>
        </div>
        <div class="w-full flex-shrink-0">
            <livewire:home.components.banner-carousel-item/>
        </div>
    </div>

    <!-- Carousel controls -->
    <div class="absolute left-0 right-0 bottom-4 flex justify-center gap-2 z-[1]">
        <button type="button"
                class="w-3 h-3 rounded-full border-2 border-primary transition-colors"
                :class="{ 'bg-primary': active === 0, 'bg-white': active !== 0 }"
                @click="goTo(0)">
        </button>
        <button type="button"
                class="w-3 h-3 rounded-full border-2 border-primary transition-colors"
                :class="{ 'bg-primary': active === 1, 'bg-white': active !== 1 }"
                @click="goTo(1)">
        </button>
    </div>

    <!-- Next/Prev buttons -->
    <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white p-2 rounded-full transition-colors z-[1]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white p-2 rounded-full transition-colors z-[1]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>

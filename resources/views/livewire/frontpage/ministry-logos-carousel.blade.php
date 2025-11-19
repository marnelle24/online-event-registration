<div class="pb-8">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-600">
                Our Partner Ministries
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Explore the diverse ministries that partner with us to bring you the best in Christian education and discipleship.
            </p>
        </div>
        
        @if($ministries->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-gray-400">No partner ministries available at the moment.</p>
            </div>
        @else
            <!-- Ministry Logos Carousel -->
            <div 
                x-data="{ 
                    currentIndex: 0,
                    itemsPerView: 6,
                    totalItems: {{ $ministries->count() }},
                    autoplayInterval: null,
                    init() {
                        this.updateItemsPerView();
                        window.addEventListener('resize', () => {
                            this.updateItemsPerView();
                            this.currentIndex = 0;
                        });
                        // Auto-play carousel
                        this.startAutoplay();
                    },
                    updateItemsPerView() {
                        if (window.innerWidth < 640) {
                            this.itemsPerView = 2;
                        } else if (window.innerWidth < 768) {
                            this.itemsPerView = 3;
                        } else if (window.innerWidth < 1024) {
                            this.itemsPerView = 4;
                        } else if (window.innerWidth < 1280) {
                            this.itemsPerView = 5;
                        } else {
                            this.itemsPerView = 6;
                        }
                    },
                    get maxIndex() {
                        const max = Math.max(0, this.totalItems - this.itemsPerView);
                        return Math.ceil(max);
                    },
                    next() {
                        if (this.currentIndex < this.maxIndex) {
                            this.currentIndex = Math.min(this.currentIndex + 1, this.maxIndex);
                        } else {
                            // Loop back to start
                            this.currentIndex = 0;
                        }
                        this.resetAutoplay();
                    },
                    prev() {
                        if (this.currentIndex > 0) {
                            this.currentIndex = Math.max(this.currentIndex - 1, 0);
                        } else {
                            // Loop to end
                            this.currentIndex = this.maxIndex;
                        }
                        this.resetAutoplay();
                    },
                    canGoNext() {
                        return this.totalItems > this.itemsPerView;
                    },
                    canGoPrev() {
                        return this.totalItems > this.itemsPerView;
                    },
                    startAutoplay() {
                        if (this.totalItems > this.itemsPerView) {
                            this.autoplayInterval = setInterval(() => {
                                this.next();
                            }, 3000); // Change slide every 3 seconds
                        }
                    },
                    stopAutoplay() {
                        if (this.autoplayInterval) {
                            clearInterval(this.autoplayInterval);
                            this.autoplayInterval = null;
                        }
                    },
                    resetAutoplay() {
                        this.stopAutoplay();
                        this.startAutoplay();
                    }
                }"
                @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()"
                class="relative"
            >
                <!-- Carousel Container -->
                <div class="relative overflow-hidden">
                    <!-- Carousel Track -->
                    <div 
                        class="flex transition-transform duration-500 ease-in-out gap-6 px-2"
                        :style="`transform: translateX(calc(-${currentIndex} * (100% / ${itemsPerView})))`"
                    >
                        @foreach($ministries as $ministry)
                            <div class="flex-shrink-0 flex items-center justify-center" 
                                 :style="`width: calc(100% / ${itemsPerView})`">
                                <div class="w-full max-w-[300px] h-auto flex items-center justify-center p-4 transition-all duration-300 transform hover:scale-105">
                                    @if($ministry->getFirstMediaUrl('ministry'))
                                        <img 
                                            src="{{ $ministry->getFirstMediaUrl('ministry') }}" 
                                            alt="{{ $ministry->name }}" 
                                            class="w-full h-auto object-contain max-h-32"
                                            loading="lazy"
                                        />
                                    @else
                                        <div class="w-full h-20 flex items-center justify-center bg-gray-100 rounded">
                                            <span class="text-gray-400 text-sm font-medium">
                                                {{ \App\Helpers\Helper::getInitials($ministry->name) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div x-show="totalItems > itemsPerView" class="mt-6">
                    <!-- Previous Button -->
                    <button
                        @click="prev()"
                        :disabled="!canGoPrev()"
                        :class="{ 'opacity-50 cursor-not-allowed': !canGoPrev(), 'opacity-100 hover:bg-teal-600': canGoPrev() }"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-8 bg-teal-500 text-white p-2 rounded-full shadow-lg transition-all duration-300 z-10 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                        aria-label="Previous ministries"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button
                        @click="next()"
                        :disabled="!canGoNext()"
                        :class="{ 'opacity-50 cursor-not-allowed': !canGoNext(), 'opacity-100 hover:bg-teal-600': canGoNext() }"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-8 bg-teal-500 text-white p-2 rounded-full shadow-lg transition-all duration-300 z-10 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                        aria-label="Next ministries"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Carousel Indicators -->
                <div class="flex justify-center mt-6 gap-2" x-show="totalItems > itemsPerView">
                    <template x-for="(item, index) in Math.ceil(totalItems / itemsPerView)" :key="index">
                        <button
                            @click="currentIndex = index * itemsPerView; resetAutoplay();"
                            :class="{ 'bg-teal-600': Math.floor(currentIndex / itemsPerView) === index, 'bg-gray-300': Math.floor(currentIndex / itemsPerView) !== index }"
                            class="w-2 h-2 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500"
                            :aria-label="`Go to slide ${index + 1}`"
                        ></button>
                    </template>
                </div>
            </div>
        @endif
    </div>
</div>


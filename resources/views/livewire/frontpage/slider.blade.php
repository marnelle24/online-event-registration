<div>
    @if ($isCarousel)
        <div class="">
            <div class="carousel relative w-full h-full border-teal-800/10 bg-gradient-to-b from-teal-800/20 to-white/40 via-teal-100 via-80%">
                <!-- Carousel items -->
                <div x-data="{ activeSlide: 0, slides: [3] }" class="relative w-full h-full max-w-6xl mx-auto px-4 py-16">
                    <!-- Slides -->
                    <div class="relative h-full w-full">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="activeSlide === index" 
                                class="absolute top-0 left-0 w-full h-full transition-opacity duration-500"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <img :src="`/images/${slide}.png`" class="object-cover w-full h-full" alt="Slide">
                                <div class="absolute inset-0 bg-zinc-100 opacity-10"></div>
                                <div class="absolute inset-0 flex items-center justify-center text-indigo-700">
                                    <div class="text-center">
                                        <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">Welcome to Our Community</h1>
                                        <p x-text="slide.title"></p>
                                        <p x-text="slide.description"></p>
                                        <p class="text-xl drop-shadow-lg">Discover amazing events and connect with others</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- Carousel Controls -->
                    <div class="absolute bottom-5 left-0 right-0 flex justify-center space-x-2">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="activeSlide = index" 
                                :class="{'bg-red-500': activeSlide === index, 'bg-white/50': activeSlide !== index}"
                                class="w-3 h-3 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-6xl mx-auto px-4 py-16">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 gap-8">
                <div class="flex flex-col justify-center items-center">
                    <h1 class="w-full xl:text-6xl text-4xl xl:text-left md:text-left text-center font-extrabold font-nunito mb-4 drop-shadow-lg text-teal-600">
                        Welcome to the streams and life's lesson
                    </h1>
                    <div class="flex flex-col gap-4">
                        <p class="xl:text-xl text-md xl:text-left md:text-left text-center text-teal-600 drop-shadow">
                            Discover amazing events and connect with others. Learn more about Streams Of Life.
                        </p>
                        <p class="xl:text-xl text-lg xl:text-left md:text-left text-center text-teal-600 drop-shadow">
                            High quality, high impact, high value trainers & speakers.
                        </p>
                    </div>
                    <div class="w-full flex xl:justify-start md:justify-start justify-center items-start mt-8">
                        <a href="#about-us" class="bg-gradient-to-r from-teal-600 via-teal-600 to-teal-600 hover:from-teal-600 hover:via-teal-500 hover:to-teal-600 text-white px-7 xl:py-3 py-2 hover:-translate-y-1 text-xl rounded-full duration-300 hover:bg-teal-500 shadow-md drop-shadow">
                            Learn More About Us
                        </a>
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/people-vector.png') }}" alt="Hero Image" class="xl:w-full xl:h-full lg:w-96 lg:h-full md:w-100 md:h-80 sm:h-48 sm:w-full h-full object-cover">
                </div>
            </div>
        </div>
    @endif
</div>

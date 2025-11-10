<div class="w-full flex flex-col items-center">
    @if(count($promotionOptions))
        <div class="w-full space-y-6">
            <div class="text-center space-y-2">
                <h3 class="md:text-3xl text-2xl font-semibold text-slate-800">Choose a registration offer</h3>
                <p class="text-md text-slate-500">Select a promotion to lock in its pricing before you proceed to registration.</p>
            </div>

            <div class="flex md:flex-row flex-col gap-4 justify-center items-center">
                @foreach($promotionOptions as $promotion)
                    <a href="{{ $promotion['url'] }}"
                       class="group flex flex-col text-center gap-4 md:h-[280px] h-auto md:w-[300px] w-full bg-gradient-to-r from-teal-700 via-teal-600 to-teal-700 border hover:from-teal-800 hover:via-teal-700 hover:to-teal-800 border-teal-600 transition-all rounded-xl px-5 py-4 shadow-sm hover:shadow-lg hover:-translate-y-0.5 duration-300">
                        <span class="text-xl uppercase text-teal-50 font-bold">{{ $promotion['title'] }}</span>
                        @if(!empty($promotion['description']))
                            <span class="text-sm text-white font-light">{{ $promotion['description'] }}</span>
                        @endif
                        <span class="text-4xl font-semibold text-white mt-auto">
                            {{ $promotion['price'] > 0 ? '$'.number_format($promotion['price'], 2) : 'Free' }}
                        </span>
                        <p class="flex mt-auto justify-center">
                            <span class="text-sm rounded-full px-5 py-2 bg-teal-500 text-white font-semibold drop-shadow-lg tracking-widest uppercase group-hover:bg-white group-hover:text-teal-500 transition-all duration-300">
                                Register Now
                            </span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ $defaultRegisterUrl }}"
           class="uppercase font-thin tracking-widest bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white py-4 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            Register Now
        </a>
    @endif
</div>


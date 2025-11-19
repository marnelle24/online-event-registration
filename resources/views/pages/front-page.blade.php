@section('title', 'Home')
<x-guest-layout>
    {{-- <div class="relative min-h-screen bg-gradient-to-b bg-white"> --}}
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-50 to-teal-50/30">
        <div class="relative w-full xl:h-[650px] h-auto overflow-hidden">
            @livewire('frontpage.slider', ['isCarousel' => false])
        </div>
        <div class="border-t-4 border-teal-800/10 bg-gradient-to-b from-teal-800/20 to-white/40 via-teal-100 via-80%">
            <div class="max-w-7xl mx-auto md:px-4 px-2 py-16 min-h-6xl">
                @livewire('frontpage.category-programme-carousel', key('frontpage-category-programme-carousel'))
            </div>
        </div>  
        <div class="bg-slate-100/60">
            <div class="max-w-7xl mx-auto md:px-4 px-2 py-16 min-h-6xl">
                @livewire('frontpage.ministry-logos-carousel')
            </div>
        </div>      
    </div>
    <x-footer-public />
</x-guest-layout>
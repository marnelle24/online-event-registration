@section('title', '{slug} Categories')
<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b bg-white">
        <div class="max-w-6xl mx-auto px-4 py-16">
            <h1 class="capitalize text-4xl font-bold mb-4">{{ $slug }} Categories</h1>
            <p class="text-lg">
                Here you can find all the {{ $slug }} categories we offer.
            </p>
        </div>
    </div>
    <x-footer-public />
</x-guest-layout>
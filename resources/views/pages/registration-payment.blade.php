@section('title', 'Complete Payment')

<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <livewire:frontpage.register.payment-page :confirmation-code="$confirmationCode" />
        </div>
    </div>
    <x-footer-public />
</x-guest-layout>


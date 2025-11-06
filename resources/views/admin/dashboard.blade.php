@section('title', 'Admin Dashboard')
<x-app-layout>
    @livewire('admin.dashboard', key('admin-dashboard'))
    
    @push('script')
        @vite('resources/js/admin-dashboard-registration-trends.js')
    @endpush
</x-app-layout>
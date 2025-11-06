<div class="py-6">
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">Admin Dashboard</h4>
            <p class="text-sm text-slate-500">Overview of your event registration system</p>
        </div>
        <div class="flex gap-3">
            <select wire:model.live="selectedPeriod" 
                class="py-2 pl-4 pr-10 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500">
                <option value="30">Last 30 days</option>
                <option value="90">Last 90 days</option>
                <option value="365">Last year</option>
            </select>
        </div>
    </div>

    
    <!-- Registration Trends Chart -->
    <livewire:admin.dashboard.registration-trends-card :selected-period="$selectedPeriod" :key="'registration-trends-' . $selectedPeriod" />
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <livewire:admin.dashboard.total-programmes-card />
        <livewire:admin.dashboard.total-registrants-card :selected-period="$selectedPeriod" :key="'total-registrants-' . $selectedPeriod" />
        <livewire:admin.dashboard.pending-payments-card />
        <livewire:admin.dashboard.total-revenue-card :selected-period="$selectedPeriod" :key="'total-revenue-' . $selectedPeriod" />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <livewire:admin.dashboard.recent-registrations-card />
        <livewire:admin.dashboard.upcoming-programmes-card />
    </div>

    <!-- Top Programmes & Payment Status -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <livewire:admin.dashboard.top-programmes-card />
        <livewire:admin.dashboard.payment-status-card />
    </div>

    <!-- Logs Viewer Section -->
    <livewire:admin.dashboard.logs-card />
</div>


<div class="lg:px-0 px-4 py-8 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 gap-4">
        <livewire:admin.programme.dashboard.total-registrants-card
            :programme-id="$programme->id"
            wire:key="programme-dashboard-total-registrants-{{ $programme->id }}"
        />

        <livewire:admin.programme.dashboard.confirmed-registrants-card
            :programme-id="$programme->id"
            wire:key="programme-dashboard-confirmed-registrants-{{ $programme->id }}"
        />

        <livewire:admin.programme.dashboard.pending-payments-card
            :programme-id="$programme->id"
            wire:key="programme-dashboard-pending-payments-{{ $programme->id }}"
        />

        <livewire:admin.programme.dashboard.revenue-summary-card
            :programme-id="$programme->id"
            wire:key="programme-dashboard-revenue-summary-{{ $programme->id }}"
        />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-8">
        <livewire:admin.programme.dashboard.registration-trend
            :programme-id="$programme->id"
            wire:key="programme-dashboard-registration-trend-{{ $programme->id }}"
        />

        <livewire:admin.programme.dashboard.revenue-trend
            :programme-id="$programme->id"
            wire:key="programme-dashboard-revenue-trend-{{ $programme->id }}"
        />
    </div>
</div>


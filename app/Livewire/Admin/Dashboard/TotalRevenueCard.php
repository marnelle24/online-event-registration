<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;
use Carbon\Carbon;

class TotalRevenueCard extends Component
{
    public string $selectedPeriod = '30';
    public float $totalRevenue = 0.0;
    public float $recentRevenue = 0.0;

    public function mount(string $selectedPeriod = '30'): void
    {
        $this->selectedPeriod = $selectedPeriod;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $days = (int) $this->selectedPeriod;
        $startDate = Carbon::now()->subDays($days);

        $baseQuery = Registrant::where('soft_delete', false)
            ->where('paymentStatus', 'verified');

        $this->totalRevenue = (clone $baseQuery)->sum('netAmount');

        $this->recentRevenue = (clone $baseQuery)
            ->where('payment_verified_at', '>=', $startDate)
            ->sum('netAmount');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.total-revenue-card');
    }
}



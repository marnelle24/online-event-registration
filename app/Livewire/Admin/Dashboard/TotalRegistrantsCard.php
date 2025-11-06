<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;
use Carbon\Carbon;

class TotalRegistrantsCard extends Component
{
    public string $selectedPeriod = '30';
    public int $totalRegistrants = 0;
    public int $recentRegistrations = 0;

    public function mount(string $selectedPeriod = '30'): void
    {
        $this->selectedPeriod = $selectedPeriod;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $days = (int) $this->selectedPeriod;
        $startDate = Carbon::now()->subDays($days);

        $this->totalRegistrants = Registrant::where('soft_delete', false)->count();

        $this->recentRegistrations = Registrant::where('soft_delete', false)
            ->where('created_at', '>=', $startDate)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.total-registrants-card');
    }
}



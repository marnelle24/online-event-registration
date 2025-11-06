<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegistrationTrendsCard extends Component
{
    public string $selectedPeriod = '30';
    public $registrationTrends;

    public function mount(string $selectedPeriod = '30'): void
    {
        $this->selectedPeriod = $selectedPeriod;
        $this->loadTrends();
    }

    protected function loadTrends(): void
    {
        $days = (int) $this->selectedPeriod;
        $startDate = Carbon::now()->subDays($days);

        $this->registrationTrends = Registrant::where('soft_delete', false)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'count' => (int) $item->count,
                ];
            });
    }

    public function render()
    {
        return view('livewire.admin.dashboard.registration-trends-card');
    }
}



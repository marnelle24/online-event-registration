<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Carbon\CarbonImmutable;
use Illuminate\View\View;
use Livewire\Component;

class TotalRegistrantsCard extends Component
{
    public int $programmeId;
    public int $totalRegistrants = 0;
    public int $recentRegistrants = 0;
    public ?float $growthPercentage = null;

    public function mount(int $programmeId): void
    {
        $this->programmeId = $programmeId;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $baseQuery = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->where('soft_delete', false);

        $this->totalRegistrants = (clone $baseQuery)->count();

        $currentPeriodStart = CarbonImmutable::now()->subDays(7);
        $previousPeriodStart = CarbonImmutable::now()->subDays(14);

        $this->recentRegistrants = (clone $baseQuery)
            ->where('created_at', '>=', $currentPeriodStart)
            ->count();

        $previousPeriodCount = (clone $baseQuery)
            ->whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])
            ->count();

        if ($previousPeriodCount > 0) {
            $this->growthPercentage = (($this->recentRegistrants - $previousPeriodCount) / $previousPeriodCount) * 100;
        } elseif ($this->recentRegistrants > 0) {
            $this->growthPercentage = 100;
        } else {
            $this->growthPercentage = null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.programme.dashboard.total-registrants-card');
    }
}


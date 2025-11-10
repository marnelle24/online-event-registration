<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Carbon\CarbonImmutable;
use Illuminate\View\View;
use Livewire\Component;

class RevenueSummaryCard extends Component
{
    private const SUCCESS_STATUSES = [
        'paid',
        'group_member_paid',
        'verified',
        'free',
    ];

    public int $programmeId;
    public float $totalRevenue = 0.0;
    public float $recentRevenue = 0.0;
    public ?float $averageTicketValue = null;

    public function mount(int $programmeId): void
    {
        $this->programmeId = $programmeId;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $baseQuery = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->where('soft_delete', false)
            ->whereIn('paymentStatus', self::SUCCESS_STATUSES);

        $this->totalRevenue = (clone $baseQuery)->sum('netAmount');

        $recentPeriodStart = CarbonImmutable::now()->subDays(7);

        $this->recentRevenue = (clone $baseQuery)
            ->where('created_at', '>=', $recentPeriodStart)
            ->sum('netAmount');

        $paidRegistrations = (clone $baseQuery)->count();
        if ($paidRegistrations > 0) {
            $this->averageTicketValue = $this->totalRevenue / $paidRegistrations;
        } else {
            $this->averageTicketValue = null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.programme.dashboard.revenue-summary-card');
    }
}


<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Carbon\CarbonImmutable;
use Illuminate\View\View;
use Livewire\Component;

class RevenueTrend extends Component
{
    private const SUCCESS_STATUSES = [
        'paid',
        'group_member_paid',
        'verified',
        'free',
    ];

    public int $programmeId;
    public array $series = [];
    public array $categories = [];

    public function mount(int $programmeId): void
    {
        $this->programmeId = $programmeId;
        $this->prepareChartData();
    }

    protected function prepareChartData(): void
    {
        $startOfWindow = CarbonImmutable::now()->startOfWeek()->subWeeks(7);
        $endOfWindow = CarbonImmutable::now()->endOfWeek();

        $registrants = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->where('soft_delete', false)
            ->whereIn('paymentStatus', self::SUCCESS_STATUSES)
            ->whereBetween('created_at', [$startOfWindow, $endOfWindow])
            ->get(['netAmount', 'created_at']);

        $grouped = $registrants->groupBy(
            fn ($registrant) => CarbonImmutable::parse($registrant->created_at)->startOfWeek()->format('Y-m-d')
        );

        $categories = [];
        $dataPoints = [];

        for ($week = 0; $week <= 7; $week++) {
            $weekStart = $startOfWindow->addWeeks($week);
            $weekKey = $weekStart->format('Y-m-d');

            $categories[] = $weekStart->format('M j');
            $dataPoints[] = round(
                $grouped->get($weekKey, collect())->sum('netAmount'),
                2
            );
        }

        $this->categories = $categories;
        $this->series = [
            [
                'name' => 'Revenue',
                'data' => $dataPoints,
            ],
        ];
    }

    public function render(): View
    {
        $chartId = 'programme-revenue-trend-' . $this->getId();

        $this->dispatch(
            'programme-revenue-trend-data',
            chartId: $chartId,
            series: $this->series,
            categories: $this->categories,
        );

        return view('livewire.admin.programme.dashboard.revenue-trend', [
            'chartId' => $chartId,
        ]);
    }
}


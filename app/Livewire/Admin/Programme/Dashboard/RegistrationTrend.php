<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class RegistrationTrend extends Component
{
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
            ->whereBetween('created_at', [$startOfWindow, $endOfWindow])
            ->get(['id', 'created_at']);

        $grouped = $registrants->groupBy(
            fn ($registrant) => CarbonImmutable::parse($registrant->created_at)->startOfWeek()->format('Y-m-d')
        );

        $categories = [];
        $dataPoints = [];

        for ($week = 0; $week <= 7; $week++) {
            $weekStart = $startOfWindow->addWeeks($week);
            $weekKey = $weekStart->format('Y-m-d');

            $categories[] = $weekStart->format('M j');
            /** @var Collection $collection */
            $collection = $grouped->get($weekKey, collect());
            $dataPoints[] = $collection->count();
        }

        $this->categories = $categories;
        $this->series = [
            [
                'name' => 'New Registrations',
                'data' => $dataPoints,
            ],
        ];
    }

    public function render(): View
    {
        $chartId = 'programme-registration-trend-' . $this->getId();

        $this->dispatch(
            'programme-registration-trend-data',
            chartId: $chartId,
            series: $this->series,
            categories: $this->categories,
        );

        return view('livewire.admin.programme.dashboard.registration-trend', [
            'chartId' => $chartId,
        ]);
    }
}


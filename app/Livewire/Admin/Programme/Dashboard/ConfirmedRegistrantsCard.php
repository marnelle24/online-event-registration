<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Illuminate\View\View;
use Livewire\Component;

class ConfirmedRegistrantsCard extends Component
{
    public int $programmeId;
    public int $confirmedCount = 0;
    public int $waitlistCount = 0;
    public ?float $confirmationRate = null;

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

        $this->confirmedCount = (clone $baseQuery)
            ->whereIn('regStatus', ['confirmed', 'attended'])
            ->count();

        $this->waitlistCount = (clone $baseQuery)
            ->whereIn('regStatus', ['pending', 'waitlisted', 'group_reg_pending'])
            ->count();

        $totalRegistrants = (clone $baseQuery)->count();

        if ($totalRegistrants > 0) {
            $this->confirmationRate = ($this->confirmedCount / $totalRegistrants) * 100;
        } else {
            $this->confirmationRate = null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.programme.dashboard.confirmed-registrants-card');
    }
}


<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Programme;
use Carbon\Carbon;

class UpcomingProgrammesCard extends Component
{
    public $upcomingProgrammes;

    public function mount(): void
    {
        $this->loadUpcomingProgrammes();
    }

    protected function loadUpcomingProgrammes(): void
    {
        $this->upcomingProgrammes = Programme::where('soft_delete', false)
            ->where('status', 'published')
            ->where('publishable', true)
            ->where('startDate', '>=', Carbon::now())
            ->with('ministry')
            ->orderBy('startDate', 'asc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.upcoming-programmes-card');
    }
}


